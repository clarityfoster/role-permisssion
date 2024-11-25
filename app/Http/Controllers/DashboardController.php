<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard() {
        $users = User::with('role')->get();
        $roles = Role::all();
        $authUser = Auth::user();
        return response()->json([
            'auth_user' => $authUser,
            'roles' => $roles,
            'users' => $users,
        ]);
    }
    public function changeUserRole(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        $user->role_id = $request->role_id;
        $user->save();

        return response()->json([
            'message' => 'User role updated successfully!',
            'user' => $user->load('role'),
        ]);
    }
    public function delete($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'deleteUser' => 'User deleted successfully!',
        ]);
    }
    public function add() {
        $validator = validator(request()->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'role_id' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $user = new User();
        $user->name = request()->name;
        $user->email = request()->email;
        $user->role_id = request()->role_id;
        $user->password = request()->password;
        $user->save();
        return response()->json([
            'user' => $user,
            'addUser' => 'User added successfully!',
        ]);
    }
    public function edit($id) {
        $user = User::findOrFail($id);
        
    }
}
