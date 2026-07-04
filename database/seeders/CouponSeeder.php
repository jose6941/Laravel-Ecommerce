<?php

namespace Database\Seeders;

use App\Models\Cupom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        Cupom::create([
            'codigo' => 'BEMVINDO10',
            'tipo' => 'porcentagem',
            'valor' => 10,
            'maximo_usos' => 500,
            'expira_em' => now()->addMonths(3),
            'ativo' => true,
        ]);

        Cupom::create([
            'codigo' => 'FRETE20',
            'tipo' => 'fixo',
            'valor' => 20,
            'maximo_usos' => null,
            'expira_em' => null,
            'ativo' => true,
        ]);
    }
}
