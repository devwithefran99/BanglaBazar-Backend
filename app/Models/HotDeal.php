<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HotDeal extends Model
{
    protected $fillable = [
        'name', 'slug', 'description',
        'price', 'old_price',
        'image', 'category',
        'stock', 'low_stock_threshold',   // ✅ added
        'is_best_sale',                   // ✅ added
        'deal_ends_at', 'is_active',
    ];

    protected $casts = [
        'deal_ends_at'  => 'datetime',
        'is_active'     => 'boolean',
        'is_best_sale'  => 'boolean',     // ✅ added
        'price'         => 'decimal:2',
        'old_price'     => 'decimal:2',
    ];

    public function hasSale(): bool
    {
        return !is_null($this->old_price) && $this->old_price > $this->price;
    }

    public function salePercent(): int
    {
        if (!$this->hasSale()) return 0;
        return round((($this->old_price - $this->price) / $this->old_price) * 100);
    }

    public function isLive(): bool
    {
        if (is_null($this->deal_ends_at)) return true;
        return Carbon::now()->lt($this->deal_ends_at);
    }

    public function remainingSeconds(): int
    {
        if (is_null($this->deal_ends_at)) return 0;
        return max(0, (int) Carbon::now()->diffInSeconds($this->deal_ends_at, false));
    }

    public function isExpired(): bool
    {
        if (!$this->deal_ends_at) return false;
        return $this->deal_ends_at->isPast();
    }
}