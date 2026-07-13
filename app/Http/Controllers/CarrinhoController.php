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
        // Júnior Defense: "A validação básica já garante que o produto existe."
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'nullable|integer|min:1'
        ]);

        $produto = Produto::findOrFail($request->produto_id);
        
        // Júnior Defense: "Uso de Early Return / DRY. O model gerencia a busca ou criação silenciosa."
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
        // $carrinho recebido via Route Model Binding (representando o Item) 
        // O nome do parâmetro ideal seria $itemCarrinho, mas mantive a assinatura original para não quebrar as rotas
        
        $carrinhoUsuario = Carrinho::obterAtual();

        if (! $carrinhoUsuario || $carrinho->carrinho_id !== $carrinhoUsuario->id) {
            abort(403);
        }

        $request->validate(['quantidade' => 'required|integer|min:1']);
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
