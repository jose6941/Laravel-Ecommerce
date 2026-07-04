<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $fillable = [
        'usuario_id', 'rotulo', 'cep', 'rua', 'numero',
        'complemento', 'bairro', 'cidade', 'estado', 'padrao',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
