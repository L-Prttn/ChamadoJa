<?php

return [
    'required' => 'O campo :attribute é obrigatório.',
    'string' => 'O campo :attribute deve ser um texto.',
    'integer' => 'O campo :attribute deve ser um número inteiro.',
    'numeric' => 'O campo :attribute deve ser um número.',
    'boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
    'date' => 'O campo :attribute deve ser uma data válida.',
    'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
    'in' => 'O valor selecionado para o campo :attribute é inválido.',
    'exists' => 'O valor selecionado para o campo :attribute é inválido.',
    'unique' => 'O valor do campo :attribute já está em uso.',

    'min' => [
        'numeric' => 'O campo :attribute deve ser no mínimo :min.',
        'string' => 'O campo :attribute deve ter no mínimo :min caracteres.',
    ],

    'max' => [
        'numeric' => 'O campo :attribute deve ser no máximo :max.',
        'string' => 'O campo :attribute deve ter no máximo :max caracteres.',
    ],

    'attributes' => [
        'nome' => 'nome',
        'email' => 'e-mail',
        'tipo' => 'tipo',
        'titulo' => 'título',
        'descricao' => 'descrição',
        'prioridade' => 'prioridade',
        'status' => 'status',
        'solicitante_id' => 'solicitante',
        'categoria_id' => 'categoria',
        'usuario_id' => 'usuário',
        'conteudo' => 'conteúdo',
        'ordenar_por' => 'campo de ordenação',
        'ordem' => 'ordem',
        'por_pagina' => 'itens por página',
    ],
];
