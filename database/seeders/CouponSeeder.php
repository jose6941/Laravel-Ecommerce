<?php

namespace Database\Seeders;

use App\Models\Cupom;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $cupons = [
            [
                'codigo' => 'BEMVINDO10',
                'tipo' => 'porcentagem',
                'valor' => 10,
                'maximo_usos' => 500,
                'expira_em' => now()->addMonths(3),
                'ativo' => true,
            ],
            [
                'codigo' => 'FRETE20',
                'tipo' => 'fixo',
                'valor' => 20,
                'maximo_usos' => null,
                'expira_em' => null,
                'ativo' => true,
            ],
            [
                'codigo' => 'BLACKFRIDAY30',
                'tipo' => 'porcentagem',
                'valor' => 30,
                'maximo_usos' => 1000,
                'expira_em' => now()->addMonth(),
                'ativo' => true,
            ],
            [
                'codigo' => 'PRIMEIRACOMPRA15',
                'tipo' => 'porcentagem',
                'valor' => 15,
                'maximo_usos' => 300,
                'expira_em' => now()->addMonths(6),
                'ativo' => true,
            ],
            [
                'codigo' => 'FRETEGRATIS50',
                'tipo' => 'fixo',
                'valor' => 50,
                'maximo_usos' => 200,
                'expira_em' => now()->addMonths(2),
                'ativo' => true,
            ],
            // Cupom expirado, útil para testar a validação de cupons inválidos.
            [
                'codigo' => 'PROMOANTIGA',
                'tipo' => 'porcentagem',
                'valor' => 25,
                'maximo_usos' => 100,
                'expira_em' => now()->subMonth(),
                'ativo' => true,
            ],
            // Cupom desativado manualmente, também útil para testes.
            [
                'codigo' => 'DESATIVADO5',
                'tipo' => 'porcentagem',
                'valor' => 5,
                'maximo_usos' => null,
                'expira_em' => null,
                'ativo' => false,
            ],
        ];

        foreach ($cupons as $dados) {
            Cupom::updateOrCreate(['codigo' => $dados['codigo']], $dados);
        }
    }
}
