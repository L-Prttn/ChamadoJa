<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::create([
            'nome' => 'Ana Souza',
            'email' => 'ana.souza@example.test',
            'senha_hash' => Hash::make('senha-demo-123'),
            'tipo' => 'usuario',
        ]);

        Usuario::create([
            'nome' => 'Carlos Oliveira',
            'email' => 'carlos.oliveira@example.test',
            'senha_hash' => Hash::make('senha-demo-123'),
            'tipo' => 'usuario',
        ]);

        Usuario::create([
            'nome' => 'Marina Atendimento',
            'email' => 'marina.atendimento@example.test',
            'senha_hash' => Hash::make('senha-demo-123'),
            'tipo' => 'atendente',
        ]);
    }
}