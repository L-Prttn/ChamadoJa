<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Chamado;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Chamado>
 */
class ChamadoFactory extends Factory
{
    protected $model = Chamado::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'solicitante_id' => Usuario::factory(),
            'categoria_id' => Categoria::factory(),
            'titulo' => fake()->sentence(4),
            'descricao' => fake()->paragraph(),
            'prioridade' => fake()->randomElement(['normal', 'alta', 'urgente']),
            'status' => 'aberto',
        ];
    }
}
