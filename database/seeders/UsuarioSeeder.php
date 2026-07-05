<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Cria clientes de exemplo, usados para gerar avaliações e pedidos
     * de demonstração de forma mais realista.
     */
    public function run(): void
    {
        if (Usuario::where('perfil', 'cliente')->count() >= 20) {
            return;
        }

        Usuario::factory()
            ->count(20)
            ->create(['perfil' => 'cliente']);
    }
}
