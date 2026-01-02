<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthApiController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255|not_in:admin',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $validatedData['password'] = Hash::make($request->password);

        $user = User::create($validatedData);

        // Passport token creation
        // Note: Client must have 'personal access client' set up via `php artisan passport:install`
        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token
        ], 201);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
