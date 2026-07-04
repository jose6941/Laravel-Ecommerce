<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrinho;
use App\Models\Endereco;
use App\Models\Pedido;
use App\Models\Cupom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DomainException;

class CheckoutController extends Controller
{
    public function index()
    {
        $carrinho = Carrinho::where('usuario_id', Auth::id())->with('itens.produto')->first();
        
        if (! $carrinho || $carrinho->itens->isEmpty()) {
            return redirect()->route('carrinho.index')->with('error', 'Seu carrinho está vazio.');
        }

        $enderecos = Endereco::where('usuario_id', Auth::id())->get();
        return view('checkout.index', compact('carrinho', 'enderecos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'endereco_id' => 'required|exists:enderecos,id',
            'metodo_pagamento' => 'required|string',
            'codigo_cupom' => 'nullable|string'
        ]);

        $usuario = Auth::user();
        $carrinho = Carrinho::where('usuario_id', $usuario->id)->with('itens.produto')->first();

        if (! $carrinho || $carrinho->itens->isEmpty()) {
            return back()->with('error', 'O carrinho está vazio.');
        }

        $endereco = Endereco::where('usuario_id', $usuario->id)->findOrFail($request->endereco_id);

        try {
            $pedido = DB::transaction(function () use ($usuario, $carrinho, $endereco, $request) {
                $subtotal = $carrinho->itens->sum(fn ($item) => $item->preco_unitario * $item->quantidade);

                $desconto = 0;
                $cupom = null;
                if ($request->codigo_cupom) {
                    $cupom = Cupom::where('codigo', $request->codigo_cupom)->first();
                    if (! $cupom || ! $cupom->valido()) {
                        throw new DomainException('Cupom inválido ou expirado.');
                    }
                    $desconto = $cupom->calcularDesconto($subtotal);
                }

                $pedido = Pedido::create([
                    'usuario_id' => $usuario->id,
                    'cupom_id' => $cupom?->id,
                    'subtotal' => $subtotal,
                    'desconto' => $desconto,
                    'frete' => 0, // simplificado
                    'total' => $subtotal - $desconto,
                    'metodo_pagamento' => $request->metodo_pagamento,
                    'endereco_entrega' => $endereco->only(['rua', 'numero', 'complemento', 'bairro', 'cidade', 'estado', 'cep']),
                ]);

                foreach ($carrinho->itens as $item) {
                    $pedido->itens()->create([
                        'produto_id' => $item->produto_id,
                        'nome_produto' => $item->produto->nome,
                        'preco_unitario' => $item->preco_unitario,
                        'quantidade' => $item->quantidade,
                        'total' => $item->preco_unitario * $item->quantidade,
                    ]);

                    $item->produto()->decrement('estoque', $item->quantidade);
                }

                // Limpa o carrinho
                $carrinho->itens()->delete();

                return $pedido;
            });
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('pedidos.show', $pedido)->with('success', 'Pedido realizado!');
    }
}
