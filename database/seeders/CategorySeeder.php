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
            'Moda Masculina',
            'Moda Feminina',
            'Casa e Decoração',
            'Esportes e Lazer',
            'Livros',
            'Beleza e Cuidados',
            'Brinquedos e Jogos',
            'Pet Shop',
            'Papelaria e Escritório',
        ];

        foreach ($categorias as $nome) {
            Categoria::updateOrCreate(
                ['slug' => Str::slug($nome)],
                ['nome' => $nome, 'ativo' => true]
            );
        }
    }
}
