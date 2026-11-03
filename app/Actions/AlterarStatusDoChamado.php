<?php

namespace App\Actions;

use App\Models\Chamado;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class AlterarStatusDoChamado
{
    private const TRANSICOES_PERMITIDAS = [
        'aberto' => ['em_andamento'],
        'em_andamento' => ['resolvido'],
        'resolvido' => ['fechado', 'em_andamento'],
        'fechado' => [],
    ];

    public function executar(
        Chamado $chamado,
        string $novoStatus,
        int $usuarioId
    ): Chamado {
        $permitidos = self::TRANSICOES_PERMITIDAS[$chamado->status] ?? [];

        if (! in_array($novoStatus, $permitidos, true)) {
            throw ValidationException::withMessages([
                'status' => ['Transição de status não permitida.'],
            ]);
        }

        return DB::transaction(function () use (
            $chamado,
            $novoStatus,
            $usuarioId
        ): Chamado {
            $statusAnterior = $chamado->status;

            $chamado->update(['status' => $novoStatus]);

            $chamado->historicoStatus()->create([
                'usuario_id' => $usuarioId,
                'status_anterior' => $statusAnterior,
                'status_novo' => $novoStatus,
            ]);

            return $chamado->refresh();
        });
    }
}