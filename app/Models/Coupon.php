<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public function isValid(): bool
    {
        if (! $this->is_active) return false;
        if ($this->expires_at?->isPast()) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;

        return true;
    }

    public function calculateDiscount(float $subtotal): float
    {
        return $this->type === 'percentage'
            ? round($subtotal * ($this->value / 100), 2)
            : min($this->value, $subtotal);
    }
}
