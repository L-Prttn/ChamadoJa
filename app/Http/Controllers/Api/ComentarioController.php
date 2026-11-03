<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArmazenarComentarioRequest;
use App\Http\Resources\ComentarioResource;
use App\Models\Chamado;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ComentarioController extends Controller
{
    public function index(Chamado $chamado): JsonResponse
    {
        $comentarios = $chamado->comentarios()
            ->with('usuario')
            ->orderBy('criado_em')
            ->get();

        return ComentarioResource::collection($comentarios)->response();
    }

    public function store(
        ArmazenarComentarioRequest $request,
        Chamado $chamado
    ): JsonResponse {
        $comentario = $chamado->comentarios()->create($request->validated());
        $comentario->load('usuario');

        return (new ComentarioResource($comentario))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}