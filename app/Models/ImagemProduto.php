<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagemProduto extends Model
{
    protected $table = 'imagens_produto';
    
    protected $fillable = ['produto_id', 'caminho', 'principal', 'ordem'];

    protected function casts(): array
    {
        return ['principal' => 'boolean'];
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->caminho);
    }
}
