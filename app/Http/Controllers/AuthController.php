<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class AuthController extends Controller
{
    public function register() {
        $validator = Validator(request()->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $user = new User();
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = request()->password;
        $user->save();
        return response()->json([
            'users' => $user,
            'success' => true,
            'register-success' =>  'Registration Success!'
        ]);
    }
    public function login() {
        $users = new User();
        $users->name = request()->name;
        $users->password = request()->password;
        $users->save();
        return response()->json([
            'user' => $user,
            
        ]);
    }
}
