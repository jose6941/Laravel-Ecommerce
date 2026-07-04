<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // imagens_produto
    public function up(): void
    {
        Schema::create('imagens_produto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained('produtos')->cascadeOnDelete();
            $table->string('caminho');
            $table->boolean('principal')->default(false);
            $table->unsignedSmallInteger('ordem')->default(0);
            $table->timestamps();
        });

        // enderecos
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->string('rotulo')->default('Principal');
            $table->string('cep', 9);
            $table->string('rua');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado', 2);
            $table->boolean('padrao')->default(false);
            $table->timestamps();
        });

        // cupons
        Schema::create('cupons', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->enum('tipo', ['porcentagem', 'fixo'])->default('porcentagem');
            $table->decimal('valor', 10, 2);
            $table->unsignedInteger('maximo_usos')->nullable();
            $table->unsignedInteger('usos')->default(0);
            $table->timestamp('expira_em')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagens_produto');
        Schema::dropIfExists('enderecos');
        Schema::dropIfExists('cupons');
    }
};
