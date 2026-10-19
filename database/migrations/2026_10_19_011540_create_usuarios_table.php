<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $tabela): void {
            $tabela->id();
            $tabela->string('nome', 150);
            $tabela->string('email', 255)->unique();
            $tabela->text('senha_hash')->nullable();
            $tabela->string('tipo', 20);
            $tabela->timestampTz('criado_em')->useCurrent();
            $tabela->timestampTz('atualizado_em')->useCurrent();
        });

        DB::statement("
            ALTER TABLE usuarios
            ADD CONSTRAINT chk_usuarios_tipo
            CHECK (tipo IN ('usuario', 'atendente'))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
