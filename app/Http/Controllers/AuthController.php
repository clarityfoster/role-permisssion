<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $check = request()->only('email', 'password');
        if (auth()->attempt($check)) {
            $user = auth()->user();
            if($user->suspended) {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Your account is suspended.',
                ], 403);
            }
            if ($user) {
                $token = $user->createToken('YourAppName')->plainTextToken;
                return response()->json([
                    'user' => $user,
                    'success' => true,
                    'token' => $token,
                    'login-success' => 'Login Successful!'
                ], 200);
            }
        }

        return response()->json([
            'success' => false,
            'login-fail' => 'Invalid email or password.',
        ], 401);
    }
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
