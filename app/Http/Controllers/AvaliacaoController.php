<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;

class AvaliacaoController extends Controller
{
    public function store(Request $request, Produto $produto){
        $request->validate([
            'nota' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string'
        ]);

        $comprou = \App\Models\ItemPedido::where('produto_id', $produto->id)
            ->whereHas('pedido', fn ($q) =>
                $q->where('usuario_id', Auth::id())
                ->whereIn('status', ['pago', 'entregue', 'enviado', 'processando'])
            )->exists();

        if (! $comprou) {
            return back()->with('error', 'Você só pode avaliar produtos que já comprou.');
        }

        if ($produto->avaliacoes()->where('usuario_id', Auth::id())->exists()) {
            return back()->with('error', 'Você já avaliou este produto.');
        }

        $produto->avaliacoes()->create([
            'usuario_id' => Auth::id(),
            'nota' => $request->nota,
            'comentario' => $request->comentario,
        ]);

        return back()->with('success', 'Avaliação enviada! Ela aparecerá após moderação.');
    }
}
