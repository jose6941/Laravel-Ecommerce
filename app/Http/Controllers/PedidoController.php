<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function show(Pedido $pedido)
    {
        if ($pedido->usuario_id !== Auth::id()) {
            abort(403);
        }

        $pedido->load('itens');

        return view('pedidos.show', compact('pedido'));
    }
}
