<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'description', 'type', 'value',
        'min_order', 'max_uses', 'used_count',
        'expires_at', 'is_active'
    ];

    protected $casts = [
        'expires_at' => 'date'
    ];

    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;
        return true;
    }

    public function calculateDiscount(float $amount): float
    {
        if ($amount < $this->min_order) return 0;

        if ($this->type === 'percentage') {
            return round($amount * $this->value / 100, 2);
        }
        return min($this->value, $amount);
    }
}