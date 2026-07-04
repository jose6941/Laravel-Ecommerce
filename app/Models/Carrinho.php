<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    protected $table = 'carrinhos';
    protected $fillable = ['usuario_id', 'sessao_id'];

    public function usuario() { return $this->belongsTo(Usuario::class); }
    public function itens()   { return $this->hasMany(ItemCarrinho::class); }
}
