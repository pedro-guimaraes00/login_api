<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {

        /** 
         * Validação de input do usuário
         * Instancia um novo usuário no DB
         * Salva e retorna msg de confirmação 
        */
        
        $request->validate([
            "name" => "required|string",
            "email" => "required|string|email|unique:users",
            "password" => "required|string|confirmed"
        ]);

        $user = new User([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);

        $user->save();

        return response()
            ->json(["response" => "Usuário criado com sucesso"], 201);

    }

    public function login(Request $request) {

        /**
         * Valida input do usuário
         * Armazena credenciais do usuário em um array
         * Verifica se ocorreu autenticação
         * Cria token de acesso
        */

        $request->validate([
            "email" => "required|string|email|",
            "password" => "required|string"
        ]);

        $credentials = [
            "email" => $request->email,
            "password" => $request->password
        ];

        if (!Auth::attempt($credentials)) {
            response()->json([
                "response" => "Acesso negado"], 401);
        }

        $user = $request->user();
        $token = $user->createToken("Token de acesso")->accessToken();

        return response()->json([
            "token" => $token
        ], 200);


    }

    public function logout(Request $request) {

        /**
         * Aplica o método revoke() para reverter token de acesso
         */
    
        $request->user()->token()->revoke();
                
            return response()->json([
                "response" => "Deslogado com sucesso"
            ]);
    }
}
