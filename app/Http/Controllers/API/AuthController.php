<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    function showLoginForm() {
        return view('auth.login'); // Exibe o formulário de login

    }
    //
    function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            dd('falhou');
            return response()->json(['error' => $validator->errors()->toJson()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('UserToken')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'message' => 'User created successfully.',
        ], 201);
    }

    function login(Request $request) {
        // Validação dos dados de login
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Tentando autenticar o usuário
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = auth()->user();
             $token = $user->createToken('UserToken')->accessToken; // Gera o token usando Sanctum ou Passport

            return response()->json([
                'token' => $token,
                'message' => 'Login bem-sucedido!'
            ], 200);
        }

        // Se as credenciais forem inválidas
        return response()->json(['message' => 'Credenciais inválidas'], 401);
    }

    function user(Request $request) {
        return response()->json(['user' => auth()->user()], 200);
    }

    function logout(Request $request) {
        // Revoga o token do usuário
        if(!$request->user()->token()) {
            // Caso o usuário não esteja logado
            return response()->json(['message' => 'Nenhum usuário logado.'], 400); // Resposta de erro
        }

        $request->user()->token()->revoke();

        return response()->json(['message' => 'Logout bem-sucedido!'], 200);

    }
}
