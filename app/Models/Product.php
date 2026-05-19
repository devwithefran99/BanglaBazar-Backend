<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'old_price',
        'stock', 'low_stock_threshold', 'image',
        'category', 'is_featured', 'is_active','supplier_id'
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
    public function supplier()
    {
        return $this->belongsTo(\App\Models\Supplier::class);
    }
    // ── Reviews ──────────────────────────────────────────

public function reviews()
{
    return $this->hasMany(Review::class, 'product_id')
                ->where('product_type', 'product');
}

public function approvedReviews()
{
    return $this->hasMany(Review::class, 'product_id')
                ->where('product_type', 'product')
                ->where('status', 'approved');
}

// average rating — review না থাকলে null
public function getAvgRatingAttribute(): ?float
{
    $avg = $this->approvedReviews()->avg('rating');
    return $avg ? round($avg, 1) : null;
}

// total approved review count
public function getReviewCountAttribute(): int
{
    return $this->approvedReviews()->count();
}
}