<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            'Eletrônicos',
            'Moda',
            'Casa e Decoração',
            'Esportes',
            'Livros',
            'Beleza',
        ];

        foreach ($categorias as $nome) {
            Categoria::create([
                'nome' => $nome,
                'slug' => Str::slug($nome),
                'ativo' => true,
            ]);
        }
    }
}
