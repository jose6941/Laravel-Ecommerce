<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;

class AvaliacaoController extends Controller
{
    public function store(Request $request, Produto $produto)
    {
        $request->validate([
            'nota' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string'
        ]);

        $produto->avaliacoes()->create([
            'usuario_id' => Auth::id(),
            'nota' => $request->nota,
            'comentario' => $request->comentario,
        ]);

        return back()->with('success', 'Avaliação enviada! Ela aparecerá após moderação.');
    }
}
