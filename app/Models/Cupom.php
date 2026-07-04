<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cupom extends Model
{
    protected $table = 'cupons';
    
    protected $fillable = ['codigo', 'tipo', 'valor', 'maximo_usos', 'usos', 'expira_em', 'ativo'];

    protected function casts(): array
    {
        return [
            'expira_em' => 'datetime',
            'ativo' => 'boolean',
        ];
    }

    public function valido(): bool
    {
        if (! $this->ativo) return false;
        if ($this->expira_em?->isPast()) return false;
        if ($this->maximo_usos && $this->usos >= $this->maximo_usos) return false;

        return true;
    }

    public function calcularDesconto(float $subtotal): float
    {
        return $this->tipo === 'porcentagem'
            ? round($subtotal * ($this->valor / 100), 2)
            : min($this->valor, $subtotal);
    }
}
