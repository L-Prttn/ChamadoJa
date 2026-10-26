<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArmazenarChamadoRequest;
use App\Http\Requests\AtualizarChamadoRequest;
use App\Http\Resources\ChamadoResource;
use App\Models\Chamado;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ChamadoController extends Controller
{
    public function index(): JsonResponse
    {
        $chamados = Chamado::with(['solicitante', 'categoria'])
            ->orderByDesc('criado_em')
            ->get();

        return ChamadoResource::collection($chamados)->response();
    }

    public function store(ArmazenarChamadoRequest $request): JsonResponse
    {
        $dados = $request->validated();
        $dados['status'] = 'aberto';

        $chamado = Chamado::create($dados);
        $chamado->load(['solicitante', 'categoria']);

        return (new ChamadoResource($chamado))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Chamado $chamado): JsonResponse
    {
        $chamado->load(['solicitante', 'categoria']);

        return (new ChamadoResource($chamado))->response();
    }

    public function update(
        AtualizarChamadoRequest $request,
        Chamado $chamado
    ): JsonResponse {
        $chamado->update($request->validated());
        $chamado->load(['solicitante', 'categoria']);

        return (new ChamadoResource($chamado))->response();
    }
}