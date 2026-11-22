<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsuarioTest extends TestCase
{
    use RefreshDatabase;

    public function test_cria_usuario_valido(): void
    {
        $resposta = $this->postJson('/api/usuarios', [
            'nome' => 'Usuario Teste',
            'email' => 'usuario.teste@example.test',
            'tipo' => 'usuario',
        ]);

        $resposta->assertCreated()
            ->assertJsonPath('dados.nome', 'Usuario Teste')
            ->assertJsonPath('dados.email', 'usuario.teste@example.test')
            ->assertJsonPath('dados.tipo', 'usuario')
            ->assertJsonMissingPath('dados.senha_hash');

        $this->assertDatabaseHas('usuarios', [
            'nome' => 'Usuario Teste',
            'email' => 'usuario.teste@example.test',
            'tipo' => 'usuario',
        ]);
    }

    public function test_campo_obrigatorio_ausente_retorna_erro_padronizado(): void
    {
        $resposta = $this->postJson('/api/usuarios', [
            'email' => 'sem.nome@example.test',
            'tipo' => 'usuario',
        ]);

        $resposta->assertStatus(422)
            ->assertJsonStructure([
                'mensagem',
                'erros' => ['nome'],
            ]);
    }
}
