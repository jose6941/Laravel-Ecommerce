<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::where('usuario_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('pedidos.index', compact('pedidos'));
    }

    public function show(Pedido $pedido)
    {
        if ($pedido->usuario_id !== Auth::id()) {
            abort(403);
        }

        $pedido->load('itens');

        return view('pedidos.show', compact('pedido'));
    }
}
