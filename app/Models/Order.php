<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'uuid', 'user_id', 'coupon_id', 'status', 'subtotal', 'discount',
        'shipping_cost', 'total', 'payment_method', 'shipping_address',
    ];

    protected function casts(): array
    {
        return ['shipping_address' => 'array']; // JSON <-> array PHP automaticamente
    }

    protected static function booted(): void
    {
        static::creating(fn (Order $order) => $order->uuid ??= (string) Str::uuid());
    }

    public function user()  { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(OrderItem::class); }

    public function getRouteKeyName(): string { return 'uuid'; } // esconde o id sequencial na URL
}
