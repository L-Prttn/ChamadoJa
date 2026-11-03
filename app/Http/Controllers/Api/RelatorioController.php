<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chamado;
use Illuminate\Http\JsonResponse;

class RelatorioController extends Controller
{
    public function resumoChamados(): JsonResponse
    {
        $porStatus = $this->contarPorStatus();
        $porPrioridade = $this->contarPorPrioridade();
        $porCategoria = $this->contarPorCategoria();

        return response()->json([
            'dados' => [
                'total' => array_sum($porStatus),
                'por_status' => $porStatus,
                'por_prioridade' => $porPrioridade,
                'por_categoria' => $porCategoria,
            ],
        ]);
    }

    /**
     * @return array<string, int>
     */
    private function contarPorStatus(): array
    {
        $totais = Chamado::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $resultado = [];

        foreach (['aberto', 'em_andamento', 'resolvido', 'fechado'] as $status) {
            $resultado[$status] = (int) ($totais[$status] ?? 0);
        }

        return $resultado;
    }

    /**
     * @return array<string, int>
     */
    private function contarPorPrioridade(): array
    {
        $totais = Chamado::query()
            ->selectRaw('prioridade, count(*) as total')
            ->groupBy('prioridade')
            ->pluck('total', 'prioridade');

        $resultado = [];

        foreach (['normal', 'alta', 'urgente'] as $prioridade) {
            $resultado[$prioridade] = (int) ($totais[$prioridade] ?? 0);
        }

        return $resultado;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function contarPorCategoria(): array
    {
        return Chamado::query()
            ->join('categorias', 'categorias.id', '=', 'chamados.categoria_id')
            ->selectRaw('categorias.id as categoria_id, categorias.nome, count(*) as total')
            ->groupBy('categorias.id', 'categorias.nome')
            ->orderBy('categorias.nome')
            ->get()
            ->map(fn ($linha) => [
                'categoria' => [
                    'id' => $linha->categoria_id,
                    'nome' => $linha->nome,
                ],
                'total' => (int) $linha->total,
            ])
            ->all();
    }
}