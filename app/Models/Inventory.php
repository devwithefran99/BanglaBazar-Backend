<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

   protected $fillable = [
    'product_id', 'product_type',
    'name', 'sku', 'category', 'stock', 'min_stock',
    'price', 'buy_price', 'unit', 'supplier', 'description', 'image', 'is_active',
];

    protected $casts = [
        'is_active' => 'boolean',
        'price'     => 'decimal:2',
    ];

    // ── Relationships ──────────────────────────────────────
    public function movements()
    {
        return $this->hasMany(InventoryMovement::class)->latest();
    }

    // Product অথবা HotDeal যেটাই হোক return করবে
    public function product()
    {
        if ($this->product_type === 'hotdeal') {
            return $this->belongsTo(HotDeal::class, 'product_id');
        }
        return $this->belongsTo(Product::class, 'product_id');
    }

    // ── Scopes ────────────────────────────────────────────
    public function scopeLowStock($query)
    {
        return $query->where('stock', '>', 0)->whereColumn('stock', '<=', 'min_stock');
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock', 0);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name',     'like', "%{$term}%")
              ->orWhere('sku',      'like', "%{$term}%")
              ->orWhere('supplier', 'like', "%{$term}%");
        });
    }

    // ── Accessors ─────────────────────────────────────────
    public function getStatusAttribute(): string
    {
        if ($this->stock <= 0)                return 'out_of_stock';
        if ($this->stock <= $this->min_stock) return 'low_stock';
        return 'in_stock';
    }

   // প্রতি unit এ profit
public function getProfitPerUnitAttribute(): float
{
    return $this->price - $this->buy_price;
}

// মোট investment (যা কিনেছো)
public function getTotalInvestmentAttribute(): float
{
    return $this->buy_price * $this->stock;
}

// মোট potential profit (যদি সব বিক্রি হয়)
public function getTotalPotentialProfitAttribute(): float
{
    return $this->profit_per_unit * $this->stock;
}

// Profit margin %
public function getProfitMarginAttribute(): float
{
    if ($this->price <= 0) return 0;
    return round(($this->profit_per_unit / $this->price) * 100, 1);
}
    // ── Static Helper: product থেকে inventory খোঁজো ──────
    public static function findByProduct($productId, $productType = 'product'): ?self
    {
        return self::where('product_id', $productId)
                   ->where('product_type', $productType)
                   ->first();
    }
}