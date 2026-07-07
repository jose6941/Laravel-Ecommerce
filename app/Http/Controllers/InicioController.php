<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;

class InicioController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::ativo()->nivelRaiz()->get();

        $produtos = Produto::ativo()
            ->with(['categoria', 'imagemPrincipal'])
            ->when($request->filled('categoria'), fn ($q) =>
                $q->whereHas('categoria', fn ($c) => $c->where('slug', $request->categoria)))
            ->when($request->filled('q'), fn ($q) =>
                $q->where('nome', 'like', "%{$request->q}%"))
            ->orderBy('destaque', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        return view('home', compact('produtos', 'categorias'));
    }
}
