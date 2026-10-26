<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChamadoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'prioridade' => $this->prioridade,
            'status' => $this->status,
            'solicitante' => $this->whenLoaded('solicitante', function () {
                return [
                    'id' => $this->solicitante->id,
                    'nome' => $this->solicitante->nome,
                ];
            }),
            'categoria' => $this->whenLoaded('categoria', function () {
                return [
                    'id' => $this->categoria->id,
                    'nome' => $this->categoria->nome,
                ];
            }),
            'criado_em' => $this->criado_em,
            'atualizado_em' => $this->atualizado_em,
        ];
    }
}
