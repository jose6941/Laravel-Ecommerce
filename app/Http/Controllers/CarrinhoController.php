<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrinho;
use App\Models\ItemCarrinho;
use App\Models\Produto;

class CarrinhoController extends Controller
{
    public function index()
    {
        $carrinho = Carrinho::obterAtual();

        if ($carrinho) {
            $carrinho->load('itens.produto.imagemPrincipal');
        }

        return view('carrinho.index', compact('carrinho'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'nullable|integer|min:1'
        ]);

        $produto = Produto::findOrFail($request->produto_id);
        $quantidade = $request->input('quantidade', 1);

        if ($quantidade > $produto->estoque) {
            return back()->with('error', 'Quantidade solicitada maior que o estoque disponível.');
        }
        
        $carrinho = Carrinho::obterAtual(criarSeNaoExistir: true);

        $quantidade = $request->input('quantidade', 1);
        $item = $carrinho->itens()->where('produto_id', $produto->id)->first();

        if ($item) {
            $item->increment('quantidade', $quantidade);
        } else {
            $carrinho->itens()->create([
                'produto_id' => $produto->id,
                'quantidade' => $quantidade,
                'preco_unitario' => $produto->preco_final,
            ]);
        }

        return redirect()->route('carrinho.index')->with('success', 'Produto adicionado ao carrinho.');
    }

    public function update(Request $request, ItemCarrinho $carrinho)
    {
        $carrinhoUsuario = Carrinho::obterAtual();

        if (! $carrinhoUsuario || $carrinho->carrinho_id !== $carrinhoUsuario->id) {
            abort(403);
        }

        $request->validate(['quantidade' => 'required|integer|min:1']);

        if ($request->quantidade > $carrinho->produto->estoque) {
            return back()->with('error', 'Quantidade solicitada maior que o estoque disponível.');
        }

        $carrinho->update(['quantidade' => $request->quantidade]);

        return back()->with('success', 'Carrinho atualizado.');
    }

    public function destroy(ItemCarrinho $carrinho)
    {
        $carrinhoUsuario = Carrinho::obterAtual();

        if (! $carrinhoUsuario || $carrinho->carrinho_id !== $carrinhoUsuario->id) {
            abort(403);
        }

        $carrinho->delete();

        return back()->with('success', 'Produto removido do carrinho.');
    }
}
