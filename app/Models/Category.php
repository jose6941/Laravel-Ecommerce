<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'parent_id', 'is_active'];

    public function parent()   { return $this->belongsTo(Category::class, 'parent_id'); }
    public function children() { return $this->hasMany(Category::class, 'parent_id'); }
    public function products() { return $this->hasMany(Product::class); }

    public function scopeActive(Builder $q): Builder    { return $q->where('is_active', true); }
    public function scopeRootLevel(Builder $q): Builder { return $q->whereNull('parent_id'); }

    public function getRouteKeyName(): string { return 'slug'; }
}
