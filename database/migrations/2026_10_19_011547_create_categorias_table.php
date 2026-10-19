<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $tabela): void {
            $tabela->id();
            $tabela->string('nome', 100)->unique();
            $tabela->text('descricao')->nullable();
            $tabela->timestampTz('criado_em')->useCurrent();
            $tabela->timestampTz('atualizado_em')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
