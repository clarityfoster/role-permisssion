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

}
