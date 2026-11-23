<?php

namespace Tests\Feature\Api;

use App\Models\Categoria;
use App\Models\Chamado;
use App\Models\HistoricoStatus;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ChamadoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(Usuario::factory()->create());
    }

    public function test_cria_chamado_valido_com_historico_de_abertura(): void
    {
        $solicitante = Usuario::factory()->create();
        $categoria = Categoria::factory()->create();

        $resposta = $this->postJson('/api/chamados', [
            'solicitante_id' => $solicitante->id,
            'categoria_id' => $categoria->id,
            'titulo' => 'Computador nao liga',
            'descricao' => 'O computador nao apresenta sinais de energia.',
            'prioridade' => 'alta',
        ]);

        $resposta->assertCreated()
            ->assertJsonPath('dados.status', 'aberto')
            ->assertJsonPath('dados.solicitante.id', $solicitante->id)
            ->assertJsonPath('dados.categoria.id', $categoria->id);

        $chamadoId = $resposta->json('dados.id');

        $this->assertDatabaseHas('chamados', [
            'id' => $chamadoId,
            'solicitante_id' => $solicitante->id,
            'categoria_id' => $categoria->id,
            'status' => 'aberto',
        ]);

        $historico = HistoricoStatus::where('chamado_id', $chamadoId)->first();

        $this->assertNotNull($historico);
        $this->assertNull($historico->status_anterior);
        $this->assertSame('aberto', $historico->status_novo);
        $this->assertSame($solicitante->id, $historico->usuario_id);
    }

    public function test_campo_obrigatorio_ausente_retorna_erro_padronizado(): void
    {
        $resposta = $this->postJson('/api/chamados', []);

        $resposta->assertStatus(422)
            ->assertJsonStructure([
                'mensagem',
                'erros' => [
                    'solicitante_id',
                    'categoria_id',
                    'titulo',
                    'descricao',
                    'prioridade',
                ],
            ]);
    }

    public function test_referencia_inexistente_retorna_erro_padronizado(): void
    {
        $resposta = $this->postJson('/api/chamados', [
            'solicitante_id' => 999999,
            'categoria_id' => 999999,
            'titulo' => 'Chamado com referencias invalidas',
            'descricao' => 'Este chamado usa um solicitante e uma categoria inexistentes.',
            'prioridade' => 'normal',
        ]);

        $resposta->assertStatus(422)
            ->assertJsonStructure([
                'mensagem',
                'erros' => [
                    'solicitante_id',
                    'categoria_id',
                ],
            ]);
    }

    public function test_consulta_de_chamado_inexistente_retorna_404(): void
    {
        $resposta = $this->getJson('/api/chamados/999999');

        $resposta->assertNotFound()
            ->assertJsonPath('mensagem', 'Recurso não encontrado.');
    }

    public function test_altera_status_com_transicao_valida(): void
    {
        $chamado = Chamado::factory()->create(['status' => 'aberto']);
        $atendente = Usuario::factory()->atendente()->create();

        $resposta = $this->patchJson("/api/chamados/{$chamado->id}/status", [
            'status' => 'em_andamento',
            'usuario_id' => $atendente->id,
        ]);

        $resposta->assertOk()
            ->assertJsonPath('dados.status', 'em_andamento');

        $this->assertDatabaseHas('chamados', [
            'id' => $chamado->id,
            'status' => 'em_andamento',
        ]);

        $this->assertDatabaseHas('historico_status', [
            'chamado_id' => $chamado->id,
            'status_anterior' => 'aberto',
            'status_novo' => 'em_andamento',
            'usuario_id' => $atendente->id,
        ]);
    }

    public function test_transicao_de_status_invalida_retorna_422(): void
    {
        $chamado = Chamado::factory()->create(['status' => 'aberto']);
        $atendente = Usuario::factory()->atendente()->create();

        $resposta = $this->patchJson("/api/chamados/{$chamado->id}/status", [
            'status' => 'fechado',
            'usuario_id' => $atendente->id,
        ]);

        $resposta->assertStatus(422)
            ->assertJsonPath('mensagem', 'Transição de status não permitida.')
            ->assertJsonPath('erros.status.0', 'Transição de status não permitida.');

        $this->assertDatabaseHas('chamados', [
            'id' => $chamado->id,
            'status' => 'aberto',
        ]);

        $this->assertDatabaseCount('historico_status', 0);
    }

    public function test_filtro_e_paginacao_de_chamados(): void
    {
        Chamado::factory()->count(2)->create(['status' => 'aberto']);
        Chamado::factory()->create(['status' => 'em_andamento']);

        $resposta = $this->getJson('/api/chamados?status=aberto&por_pagina=1');

        $resposta->assertOk()
            ->assertJsonPath('meta.total', 2)
            ->assertJsonPath('meta.per_page', 1)
            ->assertJsonCount(1, 'dados')
            ->assertJsonStructure([
                'dados',
                'links',
                'meta' => [
                    'current_page',
                    'per_page',
                    'total',
                    'last_page',
                ],
            ]);

        $this->assertSame('aberto', $resposta->json('dados.0.status'));
    }
}
