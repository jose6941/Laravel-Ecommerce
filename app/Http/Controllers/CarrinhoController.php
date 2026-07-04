<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Carrinho;
use App\Models\ItemCarrinho;
use Illuminate\Support\Facades\Auth;

class CarrinhoController extends Controller
{
    public function index()
    {
        $carrinho = $this->obterCarrinho();
        return view('carrinho.index', compact('carrinho'));
    }

    public function store(Produto $produto, Request $request)
    {
        $carrinho = $this->obterCarrinho(true);

        $item = $carrinho->itens()->where('produto_id', $produto->id)->first();

        $quantidade = $request->input('quantidade', 1);

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

    public function update(ItemCarrinho $item, Request $request)
    {
        $this->garantirQueItemPertenceAoCarrinhoAtual($item);

        $request->validate(['quantidade' => 'required|integer|min:1']);

        $item->update(['quantidade' => $request->quantidade]);

        return back()->with('success', 'Carrinho atualizado.');
    }

    public function destroy(ItemCarrinho $item)
    {
        $this->garantirQueItemPertenceAoCarrinhoAtual($item);

        $item->delete();

        return back()->with('success', 'Produto removido do carrinho.');
    }

    /**
     * Garante que o item de carrinho pertence ao usuário/sessão atual,
     * evitando que alguém manipule itens de carrinho de outra pessoa.
     */
    private function garantirQueItemPertenceAoCarrinhoAtual(ItemCarrinho $item): void
    {
        $carrinhoAtual = $this->obterCarrinho();

        abort_unless($carrinhoAtual && $item->carrinho_id === $carrinhoAtual->id, 403);
    }

    private function obterCarrinho($criarSeNaoExistir = false)
    {
        $usuario = Auth::user();
        $sessao_id = session()->getId();

        $query = Carrinho::with('itens.produto');
        
        if ($usuario) {
            $query->where('usuario_id', $usuario->id);
        } else {
            $query->where('sessao_id', $sessao_id);
        }

        $carrinho = $query->first();

        if (! $carrinho && $criarSeNaoExistir) {
            $carrinho = Carrinho::create([
                'usuario_id' => $usuario?->id,
                'sessao_id' => $sessao_id,
            ]);
        }

        return $carrinho;
    }
}
