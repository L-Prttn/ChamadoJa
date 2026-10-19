<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chamados', function (Blueprint $tabela): void {
            $tabela->id();

            $tabela->foreignId('solicitante_id')
                ->constrained('usuarios')
                ->restrictOnDelete();

            $tabela->foreignId('categoria_id')
                ->constrained('categorias')
                ->restrictOnDelete();

            $tabela->string('titulo', 200);
            $tabela->text('descricao');
            $tabela->string('prioridade', 20)->default('normal');
            $tabela->string('status', 20)->default('aberto');
            $tabela->timestampTz('criado_em')->useCurrent();
            $tabela->timestampTz('atualizado_em')->useCurrent();

            $tabela->index('status');
            $tabela->index('prioridade');
            $tabela->index('criado_em');
            $tabela->index('solicitante_id');
            $tabela->index('categoria_id');
            $tabela->index(['status', 'prioridade']);
        });

        DB::statement("
            ALTER TABLE chamados
            ADD CONSTRAINT chk_chamados_prioridade
            CHECK (prioridade IN ('normal', 'alta', 'urgente'))
        ");

        DB::statement("
            ALTER TABLE chamados
            ADD CONSTRAINT chk_chamados_status
            CHECK (status IN ('aberto', 'em_andamento', 'resolvido', 'fechado'))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chamados');
    }
};
