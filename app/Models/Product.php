<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'description',
        'price', 'promotional_price', 'stock', 'is_active', 'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'promotional_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            $product->slug ??= Str::slug($product->name) . '-' . Str::random(6);
        });
    }

    public function category() { return $this->belongsTo(Category::class); }
    public function images()   { return $this->hasMany(ProductImage::class); }
    public function reviews()  { return $this->hasMany(Review::class); }

    public function scopeActive(Builder $q): Builder   { return $q->where('is_active', true); }
    public function scopeFeatured(Builder $q): Builder { return $q->where('is_featured', true); }

    public function getFinalPriceAttribute(): float
    {
        return (float) ($this->promotional_price ?? $this->price);
    }

    public function getRouteKeyName(): string { return 'slug'; }
}
