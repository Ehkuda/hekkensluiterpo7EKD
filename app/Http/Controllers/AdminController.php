<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gedetineerde;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    /**
     * Admin dashboard
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalRoles = SpatieRole::count();
        $totalPermissions = Permission::count();
        $totalGedetineerden = Gedetineerde::count();

        // Laatste 5 gebruikers
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalRoles',
            'totalPermissions',
            'totalGedetineerden',
            'recentUsers'
        ));
    }

    /**
     * Gebruikersbeheer
     */
    public function users(Request $request)
    {
        $query = User::with('roles');

        if ($request->has('zoekterm')) {
            $term = $request->zoekterm;
            $query->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%");
        }

        $users = $query->orderBy('name')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        $roles = SpatieRole::all();
        return view('admin.users.create', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if (!empty($validated['roles'])) {
            $user->assignRole($validated['roles']);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Gebruiker succesvol aangemaakt!');
    }

    public function editUser(User $user)
    {
        $roles = SpatieRole::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);
        $user->syncRoles($validated['roles'] ?? []);

        return redirect()->route('admin.users.index')
            ->with('success', 'Gebruiker succesvol bijgewerkt!');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'Gebruiker succesvol verwijderd!');
    }

    /**
     * Rollenbeheer
     */
    public function roles(Request $request)
    {
        $query = SpatieRole::with('permissions');

        if ($request->has('zoekterm')) {
            $term = $request->zoekterm;
            $query->where('name', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
        }

        $roles = $query->orderBy('name')->paginate(10);

        return view('admin.roles.index', compact('roles'));
    }

    public function createRole()
    {
        return view('admin.roles.create');
    }

    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string|max:255',
        ]);

        SpatieRole::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'guard_name' => 'web',
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rol succesvol aangemaakt!');
    }

    public function editRole($id)
    {
        $role = SpatieRole::findById($id);
        return view('admin.roles.edit', compact('role'));
    }

    public function updateRole(Request $request, $id)
    {
        $role = SpatieRole::findById($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role->id)],
            'description' => 'nullable|string|max:255',
        ]);

        $role->update($validated);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rol succesvol bijgewerkt!');
    }

    public function deleteRole($id)
    {
        $role = SpatieRole::findById($id);

        if (in_array($role->name, ['directeur', 'coordinator', 'bewaker'])) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Basisrollen kunnen niet verwijderd worden!');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rol succesvol verwijderd!');
    }

    /**
     * Overzicht gedetineerden
     */
    public function gedetineerdenOverzicht(Request $request)
    {
        $query = Gedetineerde::with('cel');

        if ($request->has('zoekterm')) {
            $term = $request->zoekterm;
            $query->where('naam', 'like', "%{$term}%")
                  ->orWhere('idnummer', 'like', "%{$term}%");
        }

        $gedetineerden = $query->orderBy('naam')->paginate(10);

        return view('admin.gedetineerden.index', compact('gedetineerden'));
    }

    /**
     * Instellingen
     */
    public function settings()
    {
        return view('admin.settings.index');
    }

    public function updateSettings(Request $request)
    {
        // Voeg hier je instellingen update logica toe
        return redirect()->route('admin.settings.index')
            ->with('success', 'Instellingen succesvol bijgewerkt!');
    }
}
