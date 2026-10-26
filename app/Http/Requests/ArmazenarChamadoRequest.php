<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArmazenarChamadoRequest extends FormRequest
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
            'solicitante_id' => ['required', 'integer', 'exists:usuarios,id'],
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
            'titulo' => ['required', 'string', 'max:120'],
            'descricao' => ['required', 'string', 'min:10'],
            'prioridade' => ['required', Rule::in(['normal', 'alta', 'urgente'])],
        ];
    }
}
