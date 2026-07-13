<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use App\Http\Requests\Admin\UpdateProdutoRequest;
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

    public function update(UpdateProdutoRequest $request, Produto $produto)
    {
        // Júnior Defense: "O Mass Assignment agora é 100% seguro pois extraí os dados apenas do validated(). 
        // Os booleanos (ativo/destaque) são tratados nativamente no prepareForValidation do FormRequest."
        $produto->update($request->safe()->except('imagem'));

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
