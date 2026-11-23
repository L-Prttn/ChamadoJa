<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UsuarioResource;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AutenticacaoController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $dados = $request->validated();
        $usuario = Usuario::where('email', $dados['email'])->first();

        if (! $usuario || ! $usuario->senha_hash || ! Hash::check($dados['senha'], $usuario->senha_hash)) {
            return response()->json([
                'mensagem' => 'Credenciais inválidas.',
            ], 401);
        }

        $token = $usuario->createToken('api')->plainTextToken;

        return response()->json([
            'dados' => [
                'token' => $token,
                'usuario' => new UsuarioResource($usuario),
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'mensagem' => 'Token revogado.',
        ]);
    }
}
