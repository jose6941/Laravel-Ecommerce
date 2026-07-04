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
        Schema::create('carrinhos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->cascadeOnDelete();
            $table->string('sessao_id')->nullable()->index(); // usado por visitantes
            $table->timestamps();
        });

        Schema::create('itens_carrinho', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrinho_id')->constrained('carrinhos')->cascadeOnDelete();
            $table->foreignId('produto_id')->constrained('produtos')->cascadeOnDelete();
            $table->unsignedInteger('quantidade')->default(1);
            $table->decimal('preco_unitario', 10, 2); // preço "fotografado" no momento
            $table->timestamps();
            $table->unique(['carrinho_id', 'produto_id']); // não duplica o mesmo produto no carrinho
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrinhos');
        Schema::dropIfExists('itens_carrinho');
    }
};
