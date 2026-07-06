<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;

class InicioController extends Controller
{
    public function index()
    {
        $produtosDestaque = Produto::ativo()->destaque()->with(['categoria', 'imagemPrincipal'])->take(8)->get();
        $categorias = Categoria::ativo()->nivelRaiz()->get();

        return view('home', compact('produtosDestaque', 'categorias'));
    }
}
