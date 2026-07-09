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
            ->with(['categoria', 'imagemPrincipal'])
            ->when($request->filled('categoria'), fn ($q) =>
                $q->whereHas('categoria', fn ($c) => $c->where('slug', $request->categoria)))
            ->when($request->filled('q'), fn ($q) =>
                $q->where('nome', 'like', "%{$request->q}%"))
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

    public function store(Request $request)
    {
        $dados = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric',
            'preco_promocional' => 'nullable|numeric',
            'estoque' => 'required|integer',
            'sku' => 'required|string|unique:produtos,sku',
            'imagens.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $produto = Produto::create($dados);

        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $index => $file) {
                $caminho = $file->store('produtos', 'public');

                $produto->imagens()->create([
                    'caminho' => $caminho,
                    'principal' => $index === 0,
                ]);
            }
        }

        return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso.');
    }
}
