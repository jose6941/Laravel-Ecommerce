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
            ->filtrar($request->categoria, $request->q)
            ->orderBy('destaque', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        return view('home', compact('produtos', 'categorias'));
    }
}
