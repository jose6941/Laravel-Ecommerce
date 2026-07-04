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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique(); // identificador público (não mostra o id sequencial)
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('cupom_id')->nullable();
            $table->enum('status', ['pendente', 'pago', 'processando', 'enviado', 'entregue', 'cancelado'])->default('pendente');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('desconto', 10, 2)->default(0);
            $table->decimal('frete', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('metodo_pagamento')->nullable();
            $table->timestamp('pago_em')->nullable();
            $table->json('endereco_entrega'); // snapshot do endereço no momento da compra
            $table->timestamps();
        });

        Schema::create('itens_pedido', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
            $table->foreignId('produto_id')->nullable()->constrained('produtos')->nullOnDelete();
            $table->string('nome_produto');   // snapshot: nome do produto na hora da compra
            $table->decimal('preco_unitario', 10, 2);
            $table->unsignedInteger('quantidade');
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
        Schema::dropIfExists('itens_pedido');
    }
};
