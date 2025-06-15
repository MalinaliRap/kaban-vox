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
    function index() {
         // Verifica se o usuário está autenticado
        if (Auth::check()) {
            return redirect()->route('boards.create'); // Redireciona para o painel se já estiver logado
        }

        // Exibe o formulário de login com erros, caso existam
        return view('auth.login');
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

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        // Se a validação falhar, redireciona de volta com erros
        if ($validator->fails()) {
            return redirect()->route('index')->withErrors($validator)->withInput();
        }
        // Tentando autenticar o usuário
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('boards.create'); // Redireciona para o painel após login bem-sucedido
        }

        // Se as credenciais forem inválidas, exibe um erro
        return back()->withErrors(['email' => 'Credenciais inválidas'])->withInput();
    }

    function user(Request $request) {
        return response()->json(['user' => auth()->user()], 200);
    }

    function logout(Request $request) {
       // Revogar o token do usuário
        $user = Auth::logout();
        return response()->json(['message' => 'User logged out successfully.'], 200);
    }
}
