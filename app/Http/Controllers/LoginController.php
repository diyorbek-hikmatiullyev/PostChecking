<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

public function login(Request $request)
{
    \Log::info('Login request data:', $request->all()); // <-- vaqtincha qo'shing

    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required', 'min:8'],
    ]);

    $user = User::where('email', $credentials['email'])->first();
    \Log::info('Found user:', ['user' => $user]); // <-- vaqtincha qo'shing

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json([
            'message' => 'Email yoki password noto\'g\'ri',
        ], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'token'   => $token,
    ], 201);
}


    public function logout(Request $request)
    {
         $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Logged out successfully'
    ], 200);
    }
}


