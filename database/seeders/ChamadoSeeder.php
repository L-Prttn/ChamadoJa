<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Chamado;
use App\Models\Comentario;
use App\Models\HistoricoStatus;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class ChamadoSeeder extends Seeder
{
    public function run(): void
    {
        $ana = Usuario::where('email', 'ana.souza@example.test')->firstOrFail();
        $carlos = Usuario::where('email', 'carlos.oliveira@example.test')->firstOrFail();
        $marina = Usuario::where('email', 'marina.atendimento@example.test')->firstOrFail();

        $hardware = Categoria::where('nome', 'Hardware')->firstOrFail();
        $software = Categoria::where('nome', 'Software')->firstOrFail();
        $acesso = Categoria::where('nome', 'Acesso')->firstOrFail();

        $chamadoAberto = Chamado::create([
            'solicitante_id' => $ana->id,
            'categoria_id' => $hardware->id,
            'titulo' => 'Computador não liga',
            'descricao' => 'O computador não apresenta sinais de energia.',
            'prioridade' => 'alta',
            'status' => 'aberto',
        ]);

        HistoricoStatus::create([
            'chamado_id' => $chamadoAberto->id,
            'status_anterior' => null,
            'status_novo' => 'aberto',
            'usuario_id' => $ana->id,
        ]);

        Comentario::create([
            'chamado_id' => $chamadoAberto->id,
            'usuario_id' => $ana->id,
            'conteudo' => 'O problema começou hoje pela manhã.',
        ]);

        $chamadoAndamento = Chamado::create([
            'solicitante_id' => $carlos->id,
            'categoria_id' => $software->id,
            'titulo' => 'Erro ao abrir o sistema',
            'descricao' => 'O sistema apresenta uma mensagem de erro ao iniciar.',
            'prioridade' => 'normal',
            'status' => 'em_andamento',
        ]);

        HistoricoStatus::create([
            'chamado_id' => $chamadoAndamento->id,
            'status_anterior' => null,
            'status_novo' => 'aberto',
            'usuario_id' => $carlos->id,
        ]);

        HistoricoStatus::create([
            'chamado_id' => $chamadoAndamento->id,
            'status_anterior' => 'aberto',
            'status_novo' => 'em_andamento',
            'usuario_id' => $marina->id,
        ]);

        Comentario::create([
            'chamado_id' => $chamadoAndamento->id,
            'usuario_id' => $marina->id,
            'conteudo' => 'O atendimento foi iniciado e o erro está sendo analisado.',
        ]);

        $chamadoResolvido = Chamado::create([
            'solicitante_id' => $ana->id,
            'categoria_id' => $acesso->id,
            'titulo' => 'Solicitação de acesso ao sistema',
            'descricao' => 'Solicitação de acesso ao sistema interno da empresa.',
            'prioridade' => 'normal',
            'status' => 'resolvido',
        ]);

        HistoricoStatus::create([
            'chamado_id' => $chamadoResolvido->id,
            'status_anterior' => null,
            'status_novo' => 'aberto',
            'usuario_id' => $ana->id,
        ]);

        HistoricoStatus::create([
            'chamado_id' => $chamadoResolvido->id,
            'status_anterior' => 'aberto',
            'status_novo' => 'em_andamento',
            'usuario_id' => $marina->id,
        ]);

        HistoricoStatus::create([
            'chamado_id' => $chamadoResolvido->id,
            'status_anterior' => 'em_andamento',
            'status_novo' => 'resolvido',
            'usuario_id' => $marina->id,
        ]);

        Comentario::create([
            'chamado_id' => $chamadoResolvido->id,
            'usuario_id' => $marina->id,
            'conteudo' => 'O acesso foi liberado e o chamado foi resolvido.',
        ]);
    }
}