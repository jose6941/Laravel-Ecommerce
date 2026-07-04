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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->cascadeOnDelete();
            $table->string('nome');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->text('descricao')->nullable();
            $table->decimal('preco', 10, 2);
            $table->decimal('preco_promocional', 10, 2)->nullable();
            $table->unsignedInteger('estoque')->default(0);
            $table->boolean('ativo')->default(true);
            $table->boolean('destaque')->default(false);
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
