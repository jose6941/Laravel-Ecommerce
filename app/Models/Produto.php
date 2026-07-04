<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Produto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'categoria_id', 'nome', 'slug', 'sku', 'descricao',
        'preco', 'preco_promocional', 'estoque', 'ativo', 'destaque',
    ];

    protected function casts(): array
    {
        return [
            'preco' => 'decimal:2',
            'preco_promocional' => 'decimal:2',
            'ativo' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Produto $produto) {
            $produto->slug ??= Str::slug($produto->nome) . '-' . Str::random(6);
        });
    }

    public function categoria() { return $this->belongsTo(Categoria::class); }
    public function imagens()   { return $this->hasMany(ImagemProduto::class); }
    public function avaliacoes()  { return $this->hasMany(Avaliacao::class); }

    public function scopeAtivo(Builder $q): Builder   { return $q->where('ativo', true); }
    public function scopeDestaque(Builder $q): Builder { return $q->where('destaque', true); }

    public function getPrecoFinalAttribute(): float
    {
        return (float) ($this->preco_promocional ?? $this->preco);
    }

    public function getRouteKeyName(): string { return 'slug'; }
}
