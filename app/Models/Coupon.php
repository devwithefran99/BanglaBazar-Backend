<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order',
        'max_uses', 'used_count', 'expires_at', 'is_active'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active'  => 'boolean',
    ];

    // Coupon valid কিনা check
    public function isValid(float $orderTotal): array
    {
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'Coupon টি active নেই।'];
        }

        if ($this->expires_at && Carbon::now()->gt($this->expires_at)) {
            return ['valid' => false, 'message' => 'Coupon টির মেয়াদ শেষ।'];
        }

        if ($this->max_uses > 0 && $this->used_count >= $this->max_uses) {
            return ['valid' => false, 'message' => 'Coupon টির limit শেষ।'];
        }

        if ($orderTotal < $this->min_order) {
            return ['valid' => false, 'message' => 'Minimum ৳' . number_format($this->min_order, 2) . ' order করতে হবে।'];
        }

        return ['valid' => true, 'message' => 'Coupon applied!'];
    }

    // Discount calculate
    public function calculateDiscount(float $orderTotal): float
    {
        if ($this->type === 'percent') {
            return round($orderTotal * ($this->value / 100), 2);
        }
        return min($this->value, $orderTotal);
    }
}