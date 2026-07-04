<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Produto;

class PainelController extends Controller
{
    public function index()
    {
        $metricas = [
            'receita_total' => Pedido::whereIn('status', ['pago', 'entregue'])->sum('total'),
            'total_pedidos' => Pedido::count(),
            'produtos_estoque_baixo' => Produto::where('estoque', '<=', 5)->count(),
        ];

        return view('admin.dashboard', compact('metricas'));
    }
}
