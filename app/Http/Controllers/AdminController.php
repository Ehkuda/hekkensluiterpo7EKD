<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gedetineerde;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalRoles = Role::count();
        $totalPermissions = Permission::count();
        $totalGedetineerden = Gedetineerde::count();
        
        $recentUsers = User::with('roles')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalUsers', 'totalRoles', 'totalPermissions', 'totalGedetineerden', 'recentUsers'
        ));
    }

    // ===== GEBRUIKERS =====

    public function users()
    {
        $users = User::with('roles')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        $roles = Role::all();
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
            'email_verified' => 'nullable|boolean',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => $request->has('email_verified') ? now() : null,
        ]);

        if (!empty($validated['roles'])) {
            $roleNames = Role::whereIn('id', $validated['roles'])->pluck('name');
            $user->assignRole($roleNames);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Gebruiker succesvol aangemaakt!');
    }

    public function editUser(User $user)
    {
        $roles = Role::all();
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
            'email_verified' => 'nullable|boolean',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $updateData['email_verified_at'] = $request->has('email_verified') ? now() : null;

        $user->update($updateData);

        // Rollen updaten
        $user->syncRoles([]);
        if (!empty($validated['roles'])) {
            $roleNames = Role::whereIn('id', $validated['roles'])->pluck('name');
            $user->assignRole($roleNames);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Gebruiker succesvol bijgewerkt!');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Je kunt je eigen account niet verwijderen!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'Gebruiker succesvol verwijderd!');
    }

    // ===== ROLLEN =====

    public function roles()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function createRole()
    {
        $permissions = Permission::all()->groupBy('category');
        return view('admin.roles.create', compact('permissions'));
    }

    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'description' => 'nullable|string|max:500',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'guard_name' => 'web'
        ]);

        if (!empty($validated['permissions'])) {
            $permissionNames = Permission::whereIn('id', $validated['permissions'])->pluck('name');
            $role->givePermissionTo($permissionNames);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rol succesvol aangemaakt!');
    }

    public function editRole(Role $role)
    {
        $permissions = Permission::all()->groupBy('category');
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function updateRole(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role->id)],
            'description' => 'nullable|string|max:500',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        $role->syncPermissions([]);
        if (!empty($validated['permissions'])) {
            $permissionNames = Permission::whereIn('id', $validated['permissions'])->pluck('name');
            $role->givePermissionTo($permissionNames);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rol succesvol bijgewerkt!');
    }

    public function deleteRole(Role $role)
    {
        if (in_array($role->name, ['directeur', 'coordinator', 'bewaker'])) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Basisrollen kunnen niet verwijderd worden!');
        }

        $role->delete();
        return redirect()->route('admin.roles.index')
            ->with('success', 'Rol succesvol verwijderd!');
    }

    // ===== GEDETINEERDEN =====

    public function gedetineerdenOverzicht()
    {
        $gedetineerden = Gedetineerde::with('cel')->paginate(20);
        return view('admin.gedetineerden.overzicht', compact('gedetineerden'));
    }

    // ===== INSTELLINGEN =====

    public function settings()
    {
        return view('admin.settings.index');
    }

    public function updateSettings(Request $request)
    {
        // Instellingen opslaan
        return redirect()->route('admin.settings.index')
            ->with('success', 'Instellingen succesvol bijgewerkt!');
    }
}
