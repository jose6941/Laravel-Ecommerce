<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrinho;
use App\Models\ItemCarrinho;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;

class CarrinhoController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $sessaoId = session()->getId();

        if ($usuario) {
            $carrinho = Carrinho::with('itens.produto.imagemPrincipal')
                ->where('usuario_id', $usuario->id)
                ->first();
        } else {
            $carrinho = Carrinho::with('itens.produto.imagemPrincipal')
                ->where('sessao_id', $sessaoId)
                ->first();
        }

        return view('carrinho.index', compact('carrinho'));
    }

    public function store(Request $request)
    {
        $produto = Produto::findOrFail($request->produto_id);
        $usuario = Auth::user();
        $sessaoId = session()->getId();

        $carrinho = Carrinho::where($usuario ? 'usuario_id' : 'sessao_id', $usuario ? $usuario->id : $sessaoId)->first();

        if (! $carrinho) {
            $carrinho = Carrinho::create([
                'usuario_id' => $usuario?->id,
                'sessao_id' => $sessaoId,
            ]);
        }

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

    public function update(Request $request, ItemCarrinho $carrinho)
    {
        $usuario = Auth::user();
        $sessaoId = session()->getId();

        $carrinhoUsuario = Carrinho::where($usuario ? 'usuario_id' : 'sessao_id', $usuario ? $usuario->id : $sessaoId)->first();

        if (! $carrinhoUsuario || $carrinho->carrinho_id !== $carrinhoUsuario->id) {
            abort(403);
        }

        $request->validate(['quantidade' => 'required|integer|min:1']);
        $carrinho->update(['quantidade' => $request->quantidade]);

        return back()->with('success', 'Carrinho atualizado.');
    }

    public function destroy(ItemCarrinho $carrinho)
    {
        $usuario = Auth::user();
        $sessaoId = session()->getId();

        $carrinhoUsuario = Carrinho::where($usuario ? 'usuario_id' : 'sessao_id', $usuario ? $usuario->id : $sessaoId)->first();

        if (! $carrinhoUsuario || $carrinho->carrinho_id !== $carrinhoUsuario->id) {
            abort(403);
        }

        $carrinho->delete();

        return back()->with('success', 'Produto removido do carrinho.');
    }
}
