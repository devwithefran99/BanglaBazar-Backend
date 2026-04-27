<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'old_price',
        'stock', 'low_stock_threshold', 'image',
        'category', 'is_featured', 'is_active'
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

    public function isLowStock(): bool
    {
        return $this->stock <= $this->low_stock_threshold;
    }
}