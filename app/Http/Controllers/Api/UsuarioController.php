<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArmazenarUsuarioRequest;
use App\Http\Resources\UsuarioResource;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UsuarioController extends Controller
{
    public function index(): JsonResponse
    {
        $usuarios = Usuario::orderBy('nome')->get();

        return UsuarioResource::collection($usuarios)->response();
    }

    public function store(ArmazenarUsuarioRequest $request): JsonResponse
    {
        $dados = $request->validated();
        $dados['senha_hash'] = Hash::make($dados['senha']);
        unset($dados['senha']);

        $usuario = Usuario::create($dados);

        return (new UsuarioResource($usuario))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
