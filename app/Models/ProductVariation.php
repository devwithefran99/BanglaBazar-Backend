<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $fillable = [
        'product_id', 'product_type', 'label', 'price', 'old_price', 'stock', 'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function hotDeal()
    {
        return $this->belongsTo(HotDeal::class, 'product_id');
    }

    public function hasSale(): bool
    {
        return !is_null($this->old_price) && $this->old_price > $this->price;
    }

    public function salePercent(): int
    {
        if (!$this->hasSale()) return 0;
        return round((($this->old_price - $this->price) / $this->old_price) * 100);
    }
}