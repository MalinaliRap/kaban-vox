<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toJson()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('UserToken')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'message' => 'User created successfully.',
        ], 201);
    }

    function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('UserToken')->accessToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
                'message' => 'User logged in successfully.',
            ], 200);
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    function user(Request $request) {
        return response()->json(['user' => auth()->user()], 200);
    }

    function logout(Request $request) {
       // Revogar o token do usuário
        $request->user()->token()->revoke();

        return response()->json(['message' => 'User logged out successfully.'], 200);
    }
}
