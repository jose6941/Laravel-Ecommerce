<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function show(Pedido $pedido)
    {
        abort_unless($pedido->usuario_id === Auth::id(), 403);

        $pedido->load('itens');

        return view('pedidos.show', compact('pedido'));
    }
}
