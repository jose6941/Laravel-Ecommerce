<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'path', 'is_main', 'sort_order'];

    protected function casts(): array
    {
        return ['is_main' => 'boolean'];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * URL pública da imagem (disco "public", symlink em storage:link).
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
