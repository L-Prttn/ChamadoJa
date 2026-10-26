<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArmazenarUsuarioRequest;
use App\Http\Resources\UsuarioResource;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
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
        $usuario = Usuario::create($request->validated());

        return (new UsuarioResource($usuario))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}