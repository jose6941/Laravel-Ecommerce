<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Categoria extends Model
{
    protected $fillable = ['nome', 'slug', 'descricao', 'parent_id', 'ativo'];

    public function parent(){ 
        return $this->belongsTo(Categoria::class, 'parent_id'); 
    }
    public function children(){ 
        return $this->hasMany(Categoria::class, 'parent_id'); 
    }
    public function produtos(){ 
        return $this->hasMany(Produto::class); 
    }

    public function scopeAtivo(Builder $q): Builder{ 
        return $q->where('ativo', true); 
    }
    public function scopeNivelRaiz(Builder $q): Builder{ 
        return $q->whereNull('parent_id'); 
    }

    public function getRouteKeyName(): string
    { 
        return 'slug'; 
    }
}
