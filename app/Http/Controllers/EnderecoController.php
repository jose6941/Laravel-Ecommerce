<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnderecoController extends Controller
{
    public function store(Request $request)
    {
        $dados = $request->validate([
            'rotulo' => 'nullable|string|max:255',
            'cep' => 'required|string|max:9',
            'rua' => 'required|string|max:255',
            'numero' => 'required|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|size:2',
        ]);

        $dados['usuario_id'] = Auth::id();
        $dados['rotulo'] = $dados['rotulo'] ?? 'Principal';

        Endereco::create($dados);

        return back()->with('success', 'Endereço cadastrado com sucesso.');
    }

    public function destroy(Endereco $endereco)
    {
        if ($endereco->usuario_id !== Auth::id()) {
            abort(403);
        }

        $endereco->delete();

        return back()->with('success', 'Endereço removido.');
    }
}
