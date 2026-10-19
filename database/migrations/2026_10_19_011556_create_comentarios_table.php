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
        Schema::create('comentarios', function (Blueprint $tabela): void {
            $tabela->id();

            $tabela->foreignId('chamado_id')
                ->constrained('chamados')
                ->restrictOnDelete();

            $tabela->foreignId('usuario_id')
                ->constrained('usuarios')
                ->restrictOnDelete();

            $tabela->text('conteudo');
            $tabela->timestampTz('criado_em')->useCurrent();

            $tabela->index(['chamado_id', 'criado_em']);
        });

        DB::statement("
            ALTER TABLE comentarios
            ADD CONSTRAINT chk_comentarios_conteudo
            CHECK (LENGTH(TRIM(conteudo)) > 0)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
