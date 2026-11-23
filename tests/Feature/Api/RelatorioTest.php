<?php

namespace Tests\Feature\Api;

use App\Models\Categoria;
use App\Models\Chamado;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RelatorioTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(Usuario::factory()->create());
    }

    public function test_resumo_agrupa_chamados_por_status_prioridade_e_categoria(): void
    {
        $solicitante = Usuario::factory()->create();
        $hardware = Categoria::factory()->create(['nome' => 'Hardware']);
        $software = Categoria::factory()->create(['nome' => 'Software']);

        Chamado::factory()->create([
            'solicitante_id' => $solicitante->id,
            'categoria_id' => $hardware->id,
            'status' => 'aberto',
            'prioridade' => 'alta',
        ]);

        Chamado::factory()->create([
            'solicitante_id' => $solicitante->id,
            'categoria_id' => $hardware->id,
            'status' => 'em_andamento',
            'prioridade' => 'urgente',
        ]);

        Chamado::factory()->create([
            'solicitante_id' => $solicitante->id,
            'categoria_id' => $software->id,
            'status' => 'fechado',
            'prioridade' => 'normal',
        ]);

        $resposta = $this->getJson('/api/relatorios/resumo-chamados');

        $resposta->assertOk()
            ->assertJsonPath('dados.total', 3)
            ->assertJsonPath('dados.por_status.aberto', 1)
            ->assertJsonPath('dados.por_status.em_andamento', 1)
            ->assertJsonPath('dados.por_status.resolvido', 0)
            ->assertJsonPath('dados.por_status.fechado', 1)
            ->assertJsonPath('dados.por_prioridade.normal', 1)
            ->assertJsonPath('dados.por_prioridade.alta', 1)
            ->assertJsonPath('dados.por_prioridade.urgente', 1)
            ->assertJsonCount(2, 'dados.por_categoria')
            ->assertJsonPath('dados.por_categoria.0.categoria.id', $hardware->id)
            ->assertJsonPath('dados.por_categoria.0.categoria.nome', 'Hardware')
            ->assertJsonPath('dados.por_categoria.0.total', 2)
            ->assertJsonPath('dados.por_categoria.1.categoria.id', $software->id)
            ->assertJsonPath('dados.por_categoria.1.categoria.nome', 'Software')
            ->assertJsonPath('dados.por_categoria.1.total', 1);
    }
}
