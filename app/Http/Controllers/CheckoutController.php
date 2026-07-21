<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrinho;
use App\Models\Endereco;
use App\Models\Pedido;
use App\Models\Cupom;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $carrinho = Carrinho::where('usuario_id', $request->user()->id)->with('itens.produto')->first();

        if (! $carrinho || $carrinho->itens->isEmpty()) {
            return redirect()->route('carrinho.index')->with('error', 'Seu carrinho está vazio.');
        }

        $enderecos = Endereco::where('usuario_id', $request->user()->id)->get();

        return view('checkout.index', compact('carrinho', 'enderecos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'endereco_id' => 'required|exists:enderecos,id',
            'metodo_pagamento' => 'required|string',
            'codigo_cupom' => 'nullable|string'
        ]);

        $usuario = $request->user();
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
                    $cupom = Cupom::where('codigo', $request->codigo_cupom)
                        ->lockForUpdate()
                        ->first();

                    if (! $cupom || ! $cupom->valido()) {
                        throw new \Exception('Cupom inválido ou expirado.');
                    }

                    $desconto = $cupom->calcularDesconto($subtotal);
                    $cupom->increment('usos'); // <-- faltava isso
                }

                $pedido = Pedido::create([
                    'usuario_id' => $usuario->id,
                    'cupom_id' => $cupom?->id,
                    'subtotal' => $subtotal,
                    'desconto' => $desconto,
                    'frete' => 0,
                    'total' => $subtotal - $desconto,
                    'metodo_pagamento' => $request->metodo_pagamento,
                    'endereco_entrega' => $endereco->only(['rua', 'numero', 'complemento', 'bairro', 'cidade', 'estado', 'cep']),
                ]);

                foreach ($carrinho->itens as $item) {
                    $produto = Produto::where('id', $item->produto_id)
                        ->lockForUpdate()
                        ->first();

                    if ($produto->estoque < $item->quantidade) {
                        throw new \Exception("Estoque insuficiente para \"{$produto->nome}\".");
                    }

                    $pedido->itens()->create([
                        'produto_id'     => $item->produto_id,
                        'nome_produto'   => $produto->nome,
                        'preco_unitario' => $item->preco_unitario,
                        'quantidade'     => $item->quantidade,
                        'total'          => $item->preco_unitario * $item->quantidade,
                    ]);

                    $produto->decrement('estoque', $item->quantidade);
                }

                $carrinho->itens()->delete();

                return $pedido;
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('pedidos.show', $pedido)->with('success', 'Pedido realizado!');
    }
}
