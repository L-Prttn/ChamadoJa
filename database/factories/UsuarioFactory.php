<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Usuario>
 */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'senha_hash' => Hash::make('senha-teste'),
            'tipo' => 'usuario',
        ];
    }

    public function atendente(): static
    {
        return $this->state(fn (array $attributes): array => [
            'tipo' => 'atendente',
        ]);
    }
}
