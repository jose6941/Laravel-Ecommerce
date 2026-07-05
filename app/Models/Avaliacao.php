<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    protected $table = 'avaliacoes';
    protected $fillable = ['produto_id', 'usuario_id', 'nota', 'comentario', 'aprovado'];

    public function produto(){ 
        return $this->belongsTo(Produto::class); 
    }
    public function usuario(){ 
        return $this->belongsTo(Usuario::class); 
    }
}
