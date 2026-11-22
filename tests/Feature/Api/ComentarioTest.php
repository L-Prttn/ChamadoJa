<?php

namespace Tests\Feature\Api;

use App\Models\Chamado;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComentarioTest extends TestCase
{
    use RefreshDatabase;

    public function test_cria_comentario_valido(): void
    {
        $chamado = Chamado::factory()->create();
        $autor = Usuario::factory()->create();

        $resposta = $this->postJson("/api/chamados/{$chamado->id}/comentarios", [
            'usuario_id' => $autor->id,
            'conteudo' => 'O problema continua acontecendo.',
        ]);

        $resposta->assertCreated()
            ->assertJsonPath('dados.conteudo', 'O problema continua acontecendo.')
            ->assertJsonPath('dados.autor.id', $autor->id);

        $this->assertDatabaseHas('comentarios', [
            'chamado_id' => $chamado->id,
            'usuario_id' => $autor->id,
            'conteudo' => 'O problema continua acontecendo.',
        ]);
    }

    public function test_comentario_com_campo_obrigatorio_ausente_retorna_erro_padronizado(): void
    {
        $chamado = Chamado::factory()->create();
        $autor = Usuario::factory()->create();

        $resposta = $this->postJson("/api/chamados/{$chamado->id}/comentarios", [
            'usuario_id' => $autor->id,
        ]);

        $resposta->assertStatus(422)
            ->assertJsonStructure([
                'mensagem',
                'erros' => ['conteudo'],
            ]);
    }

    public function test_comentario_com_autor_inexistente_retorna_erro_padronizado(): void
    {
        $chamado = Chamado::factory()->create();

        $resposta = $this->postJson("/api/chamados/{$chamado->id}/comentarios", [
            'usuario_id' => 999999,
            'conteudo' => 'Comentario com autor inexistente.',
        ]);

        $resposta->assertStatus(422)
            ->assertJsonStructure([
                'mensagem',
                'erros' => ['usuario_id'],
            ]);
    }

    public function test_comentario_em_chamado_inexistente_retorna_404(): void
    {
        $autor = Usuario::factory()->create();

        $resposta = $this->postJson('/api/chamados/999999/comentarios', [
            'usuario_id' => $autor->id,
            'conteudo' => 'Comentario em chamado inexistente.',
        ]);

        $resposta->assertNotFound()
            ->assertJsonPath('mensagem', 'Recurso não encontrado.');
    }
}
