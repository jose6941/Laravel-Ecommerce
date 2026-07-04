<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@acme.com.br'],
            ['name' => 'Administrador', 'password' => 'senha123', 'role' => 'admin']
        );
    }
}
