<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = Categoria::all();

        if ($categorias->isEmpty()) {
            $this->call(CategorySeeder::class);
            $categorias = Categoria::all();
        }

        $produtos = [
            ['nome' => 'Fone de Ouvido Bluetooth', 'preco' => 199.90, 'destaque' => true],
            ['nome' => 'Smartwatch Sport', 'preco' => 349.90, 'destaque' => true],
            ['nome' => 'Camiseta Básica Algodão', 'preco' => 59.90, 'destaque' => true],
            ['nome' => 'Tênis de Corrida', 'preco' => 279.90, 'destaque' => true],
            ['nome' => 'Luminária de Mesa LED', 'preco' => 89.90, 'destaque' => false],
            ['nome' => 'Kit Panelas Antiaderentes', 'preco' => 249.90, 'destaque' => true],
            ['nome' => 'Bola de Futebol Oficial', 'preco' => 129.90, 'destaque' => false],
            ['nome' => 'Livro: Introdução à Programação', 'preco' => 79.90, 'destaque' => true],
            ['nome' => 'Kit Skincare Facial', 'preco' => 159.90, 'destaque' => false],
            ['nome' => 'Mochila para Notebook', 'preco' => 149.90, 'destaque' => false],
        ];

        foreach ($produtos as $index => $dados) {
            $slug = Str::slug($dados['nome']);

            $produto = Produto::create([
                'categoria_id' => $categorias->random()->id,
                'nome' => $dados['nome'],
                'slug' => $slug,
                'sku' => 'SKU-'.str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                'descricao' => 'Descrição de exemplo para '.$dados['nome'].'.',
                'preco' => $dados['preco'],
                'preco_promocional' => null,
                'estoque' => rand(5, 50),
                'ativo' => true,
                'destaque' => $dados['destaque'],
            ]);

            $produto->imagens()->create([
                // Imagem de exemplo (placeholder) — troque pelo caminho real do produto
                // quando tiver as fotos definitivas.
                'caminho' => "https://picsum.photos/seed/{$slug}/600/600",
                'principal' => true,
                'ordem' => 0,
            ]);
        }
    }
}
