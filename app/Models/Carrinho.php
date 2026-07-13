<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Carrinho extends Model
{
    protected $table = 'carrinhos';
    protected $fillable = ['usuario_id', 'sessao_id'];

    public function usuario(){ 
        return $this->belongsTo(Usuario::class); 
    }
    public function itens(){ 
        return $this->hasMany(ItemCarrinho::class); 
    }

    /**
     * Retorna o carrinho atual da sessão ou do usuário autenticado.
     * Pode criar um novo se não existir e o parâmetro $criarSeNaoExistir for true.
     */
    public static function obterAtual(bool $criarSeNaoExistir = false): ?self
    {
        $usuario = Auth::user();
        $sessaoId = session()->getId();

        $carrinho = self::where(
            $usuario ? 'usuario_id' : 'sessao_id',
            $usuario ? $usuario->id : $sessaoId
        )->first();

        if (!$carrinho && $criarSeNaoExistir) {
            $carrinho = self::create([
                'usuario_id' => $usuario?->id,
                'sessao_id'  => $sessaoId,
            ]);
        }

        return $carrinho;
    }
}
