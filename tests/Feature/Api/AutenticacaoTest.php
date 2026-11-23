<?php

namespace Tests\Feature\Api;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutenticacaoTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_com_credenciais_validas_retorna_token(): void
    {
        $usuario = Usuario::factory()->create([
            'email' => 'login@example.test',
        ]);

        $resposta = $this->postJson('/api/login', [
            'email' => 'login@example.test',
            'senha' => 'senha-teste',
        ]);

        $resposta->assertOk()
            ->assertJsonPath('dados.usuario.email', 'login@example.test')
            ->assertJsonStructure([
                'dados' => [
                    'token',
                    'usuario' => ['id', 'nome', 'email', 'tipo'],
                ],
            ]);

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $usuario->id,
            'tokenable_type' => Usuario::class,
        ]);
    }

    public function test_login_com_senha_incorreta_retorna_401(): void
    {
        Usuario::factory()->create([
            'email' => 'login@example.test',
        ]);

        $resposta = $this->postJson('/api/login', [
            'email' => 'login@example.test',
            'senha' => 'senha-errada',
        ]);

        $resposta->assertStatus(401)
            ->assertJsonPath('mensagem', 'Credenciais inválidas.');
    }

    public function test_logout_sem_token_retorna_401(): void
    {
        $this->postJson('/api/logout')
            ->assertStatus(401)
            ->assertJsonPath('mensagem', 'Não autenticado.');
    }

    public function test_logout_com_token_revoga_o_token(): void
    {
        $usuario = Usuario::factory()->create();
        $token = $usuario->createToken('teste');

        $this->withHeader('Authorization', 'Bearer '.$token->plainTextToken)
            ->postJson('/api/logout')
            ->assertOk()
            ->assertJsonPath('mensagem', 'Token revogado.');

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $token->accessToken->id,
        ]);
    }

    public function test_rota_protegida_sem_token_retorna_401(): void
    {
        $this->getJson('/api/chamados')
            ->assertStatus(401)
            ->assertJsonPath('mensagem', 'Não autenticado.');
    }
}
