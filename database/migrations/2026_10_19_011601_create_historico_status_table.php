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
        Schema::create('historico_status', function (Blueprint $tabela): void {
            $tabela->id();

            $tabela->foreignId('chamado_id')
                ->constrained('chamados')
                ->restrictOnDelete();

            $tabela->string('status_anterior', 20)->nullable();
            $tabela->string('status_novo', 20);

            $tabela->foreignId('usuario_id')
                ->constrained('usuarios')
                ->restrictOnDelete();

            $tabela->timestampTz('criado_em')->useCurrent();

            $tabela->index(['chamado_id', 'criado_em']);
        });

        DB::statement("
            ALTER TABLE historico_status
            ADD CONSTRAINT chk_historico_status_anterior
            CHECK (
                status_anterior IS NULL
                OR status_anterior IN ('aberto', 'em_andamento', 'resolvido', 'fechado')
            )
        ");

        DB::statement("
            ALTER TABLE historico_status
            ADD CONSTRAINT chk_historico_status_novo
            CHECK (
                status_novo IN ('aberto', 'em_andamento', 'resolvido', 'fechado')
            )
        ");

        DB::statement("
            ALTER TABLE historico_status
            ADD CONSTRAINT chk_historico_transicao
            CHECK (
                (status_anterior IS NULL AND status_novo = 'aberto')
                OR (
                    status_anterior IS NOT NULL
                    AND status_anterior <> status_novo
                )
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_status');
    }
};
