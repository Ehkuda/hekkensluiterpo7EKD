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
    // Dashboard
    public function dashboard() {
        $totalUsers = User::count();
        $totalRoles = SpatieRole::count();
        $totalPermissions = Permission::count();
        $totalGedetineerden = Gedetineerde::count();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers','totalRoles','totalPermissions','totalGedetineerden','recentUsers'));
    }

    // Users
    public function users(Request $request) { /* ... kopieer je huidige logic ... */ }
    public function createUser() { /* ... */ }
    public function storeUser(Request $request) { /* ... */ }
    public function editUser(User $user) { /* ... */ }
    public function updateUser(Request $request, User $user) { /* ... */ }
    public function deleteUser(User $user) { /* ... */ }

    // Roles
    public function roles(Request $request) {
        $roles = SpatieRole::with('permissions')->orderBy('name')->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function createRole() {
        $permissions = Permission::all()->sortBy('name');
        return view('admin.roles.create', compact('permissions'));
    }

    public function storeRole(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string|max:255',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = SpatieRole::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'guard_name' => 'web',
        ]);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions(Permission::whereIn('id', $validated['permissions'])->pluck('name')->toArray());
        }

        return redirect()->route('admin.roles.index')->with('success','Rol succesvol aangemaakt!');
    }

    public function editRole($role) {
        $role = SpatieRole::findById($role);
        $permissions = Permission::all()->sortBy('name');
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role','permissions','rolePermissions'));
    }

    public function updateRole(Request $request, $role) {
        $role = SpatieRole::findById($role);

        $validated = $request->validate([
            'name' => ['required','string','max:255',Rule::unique('roles')->ignore($role->id)],
            'description' => 'nullable|string|max:255',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        $role->syncPermissions(!empty($validated['permissions']) ? Permission::whereIn('id', $validated['permissions'])->pluck('name')->toArray() : []);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.roles.index')->with('success','Rol succesvol bijgewerkt!');
    }

    public function deleteRole($role) {
        $role = SpatieRole::findById($role);

        if (in_array($role->name,['directeur','coordinator','bewaker'])) {
            return redirect()->route('admin.roles.index')->with('error','Basisrollen kunnen niet verwijderd worden!');
        }

        $role->delete();
        return redirect()->route('admin.roles.index')->with('success','Rol succesvol verwijderd!');
    }

    // Gedetineerden overzicht (admin)
    public function gedetineerdenOverzicht(Request $request) {
        $gedetineerden = Gedetineerde::with('cel')->orderBy('naam')->paginate(10);
        return view('admin.gedetineerden.index', compact('gedetineerden'));
    }

    // Settings
    public function settings() { return view('admin.settings.index'); }
    public function updateSettings(Request $request) { return redirect()->route('admin.settings.index')->with('success','Instellingen succesvol bijgewerkt!'); }
}
