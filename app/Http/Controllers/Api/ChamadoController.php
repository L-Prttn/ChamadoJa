<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArmazenarChamadoRequest;
use App\Http\Requests\AtualizarChamadoRequest;
use App\Http\Resources\ChamadoResource;
use App\Models\Chamado;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Actions\AlterarStatusDoChamado;
use App\Http\Requests\AlterarStatusRequest;
use App\Http\Resources\HistoricoStatusResource;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ListarChamadosRequest;

class ChamadoController extends Controller
{
    public function index(ListarChamadosRequest $request): JsonResponse
    {
        $dados = $request->validated();

        $ordenarPor = $dados['ordenar_por'] ?? 'criado_em';
        $ordem = $dados['ordem'] ?? 'desc';
        $porPagina = (int) ($dados['por_pagina'] ?? 15);

        $consulta = Chamado::query()
            ->with(['solicitante', 'categoria'])
            ->when(
                $dados['status'] ?? null,
                fn ($consulta, $status) => $consulta->where('status', $status)
            )
            ->when(
                $dados['prioridade'] ?? null,
                fn ($consulta, $prioridade) => $consulta->where('prioridade', $prioridade)
            )
            ->when(
                $dados['categoria_id'] ?? null,
                fn ($consulta, $id) => $consulta->where('categoria_id', $id)
            )
            ->when(
                $dados['solicitante_id'] ?? null,
                fn ($consulta, $id) => $consulta->where('solicitante_id', $id)
            );

        if ($ordenarPor === 'prioridade') {
            $consulta->orderByRaw(
                "case prioridade when 'urgente' then 1 when 'alta' then 2 else 3 end {$ordem}"
            );
        } else {
            $consulta->orderBy($ordenarPor, $ordem);
        }

        $chamados = $consulta
            ->orderBy('id')
            ->paginate($porPagina);

        return ChamadoResource::collection($chamados)->response();
    }

    public function store(ArmazenarChamadoRequest $request): JsonResponse
    {
        $dados = $request->validated();
        $dados['status'] = 'aberto';

        $chamado = DB::transaction(function () use ($dados): Chamado {
            $chamado = Chamado::create($dados);

            $chamado->historicoStatus()->create([
                'usuario_id' => $chamado->solicitante_id,
                'status_anterior' => null,
                'status_novo' => 'aberto',
            ]);

            return $chamado;
        });

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

    public function alterarStatus(
        AlterarStatusRequest $request,
        Chamado $chamado,
        AlterarStatusDoChamado $alterarStatus
    ): JsonResponse {
        $dados = $request->validated();

        $chamado = $alterarStatus->executar(
            $chamado,
            $dados['status'],
            $dados['usuario_id']
        );

        $chamado->load(['solicitante', 'categoria']);

        return (new ChamadoResource($chamado))->response();
    }

    public function historico(Chamado $chamado): JsonResponse
    {
        $historicos = $chamado->historicoStatus()
            ->with('usuario')
            ->orderBy('criado_em')
            ->orderBy('id')
            ->get();

        return HistoricoStatusResource::collection($historicos)->response();
    }

}
