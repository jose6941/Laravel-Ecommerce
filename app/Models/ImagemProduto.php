<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        // Imagens de seeders/demonstração usam URLs completas (ex: serviços de
        // placeholder). Imagens enviadas pelo formulário de produto usam apenas
        // o caminho relativo dentro do disco "public". Tratamos os dois casos
        // para que a imagem sempre seja exibida corretamente nas páginas.
        if (Str::startsWith($this->caminho, ['http://', 'https://'])) {
            return $this->caminho;
        }

        return asset('storage/' . $this->caminho);
    }
}
