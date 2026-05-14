<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'supplier_id', 'product_name', 'quantity',
        'buying_price', 'purchase_date', 'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'buying_price'  => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function getTotalCostAttribute(): float
    {
        return $this->quantity * $this->buying_price;
    }
}