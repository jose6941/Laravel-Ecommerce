<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::updateOrCreate(
            ['email' => 'admin@acme.com.br'],
            ['nome' => 'Administrador', 'senha' => 'senha123', 'perfil' => 'admin']
        );
    }
}
