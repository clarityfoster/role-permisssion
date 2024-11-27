<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return response()->json([
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }
    public function updateRolePermissions(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);

        // Sync permissions (replaces current permissions with new ones)
        $role->permissions()->sync($request->permissions);

        return response()->json(['message' => 'Permissions updated successfully.']);
    }

    public function add(Request $request) {
        $validator = validator($request->all(), [
            'role' => 'required|string|max:255|unique:roles,role',
            'permissions' => 'array|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $role = new Role();
            $role->role = $request->role;
            $role->save();

            if ($request->has('permissions')) {
                $role->permissions()->sync($request->permissions);
            }

            return response()->json([
                'role' => $role,
                'message' => 'Role added successfully!',
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error adding role:', ['exception' => $e->getMessage()]);

            return response()->json([
                'message' => 'Failed to add role. Please try again.',
            ], 500);
        }
    }

}
