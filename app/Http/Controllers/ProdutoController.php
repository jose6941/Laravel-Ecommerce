<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $produtos = Produto::ativo()
            ->with(['categoria', 'imagemPrincipal', 'avaliacoesAprovadas'])
            ->filtrar($request->categoria, $request->q)
            ->paginate(12)
            ->withQueryString();

        $categorias = Categoria::ativo()->nivelRaiz()->orderBy('nome')->get();

        return view('produtos.index', compact('produtos', 'categorias'));
    }

    public function show(Produto $produto)
    {
        if (! $produto->ativo) {
            abort(404);
        }

        $produto->load('imagens', 'categoria', 'avaliacoesAprovadas.usuario');

        return view('produtos.show', compact('produto'));
    }

}
