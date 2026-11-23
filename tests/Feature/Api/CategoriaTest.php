<?php

namespace Tests\Feature\Api;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoriaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(Usuario::factory()->create());
    }

    public function test_cria_categoria_valida(): void
    {
        $resposta = $this->postJson('/api/categorias', [
            'nome' => 'Hardware Teste',
            'descricao' => 'Problemas relacionados a equipamentos.',
        ]);

        $resposta->assertCreated()
            ->assertJsonPath('dados.nome', 'Hardware Teste')
            ->assertJsonPath('dados.descricao', 'Problemas relacionados a equipamentos.');

        $this->assertDatabaseHas('categorias', [
            'nome' => 'Hardware Teste',
        ]);
    }

    public function test_campo_obrigatorio_ausente_retorna_erro_padronizado(): void
    {
        $resposta = $this->postJson('/api/categorias', [
            'descricao' => 'Categoria sem nome.',
        ]);

        $resposta->assertStatus(422)
            ->assertJsonStructure([
                'mensagem',
                'erros' => ['nome'],
            ]);
    }
}
