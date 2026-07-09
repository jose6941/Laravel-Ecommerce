<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class AdminProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::with('categoria')->latest()->paginate(20);
        return view('admin.produtos.index', compact('produtos'));
    }

    public function edit(Produto $produto)
    {
        $categorias = Categoria::all();
        return view('admin.produtos.edit', compact('produto', 'categorias'));
    }

    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric|min:0',
            'preco_promocional' => 'nullable|numeric|min:0',
            'estoque' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('imagem');
        $data['ativo'] = $request->has('ativo');
        $data['destaque'] = $request->has('destaque');

        $produto->update($data);

        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('produtos', 'public');

            $produto->imagens()->update(['principal' => false]);

            $produto->imagens()->create([
                'caminho' => $path,
                'principal' => true,
                'ordem' => 1
            ]);
        }

        return redirect()->route('admin.produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }
}
