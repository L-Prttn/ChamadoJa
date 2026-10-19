<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        Categoria::create([
            'nome' => 'Hardware',
            'descricao' => 'Problemas relacionados a computadores e periféricos.',
        ]);

        Categoria::create([
            'nome' => 'Software',
            'descricao' => 'Problemas relacionados a sistemas e aplicativos.',
        ]);

        Categoria::create([
            'nome' => 'Acesso',
            'descricao' => 'Solicitações de acesso a sistemas e recursos.',
        ]);
    }
}