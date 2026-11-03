<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListarChamadosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['sometimes', 'required', Rule::in(['aberto', 'em_andamento', 'resolvido', 'fechado'])],
            'prioridade' => ['sometimes', 'required', Rule::in(['normal', 'alta', 'urgente'])],
            'categoria_id' => ['sometimes', 'required', 'integer', 'min:1'],
            'solicitante_id' => ['sometimes', 'required', 'integer', 'min:1'],
            'ordenar_por' => ['sometimes', 'required', Rule::in(['criado_em', 'prioridade', 'status'])],
            'ordem' => ['sometimes', 'required', Rule::in(['asc', 'desc'])],
            'por_pagina' => ['sometimes', 'required', 'integer', 'min:1', 'max:100'],
        ];
    }
}
