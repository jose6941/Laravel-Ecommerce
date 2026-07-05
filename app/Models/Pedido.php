<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pedido extends Model
{
    protected $fillable = [
        'uuid', 'usuario_id', 'cupom_id', 'status', 'subtotal', 'desconto',
        'frete', 'total', 'metodo_pagamento', 'endereco_entrega',
    ];

    protected function casts(): array
    {
        return ['endereco_entrega' => 'array'];
    }

    protected static function booted(): void
    {
        static::creating(fn (Pedido $pedido) => $pedido->uuid ??= (string) Str::uuid());
    }

    public function usuario(){ 
        return $this->belongsTo(Usuario::class); 
    }
    public function itens(){ 
        return $this->hasMany(ItemPedido::class); 
    }
    public function cupom(){ 
        return $this->belongsTo(Cupom::class); 
    }

    public function getRouteKeyName(): string
    { 
        return 'uuid'; 
    }
}
