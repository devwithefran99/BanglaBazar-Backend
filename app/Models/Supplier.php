<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'address', 'notes',
        'total_purchase', 'total_paid', 'status',
    ];

    protected $casts = [
        'total_purchase' => 'decimal:2',
        'total_paid'     => 'decimal:2',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function payments()
    {
        return $this->hasMany(SupplierPayment::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function getDueAmountAttribute(): float
    {
        return max(0, $this->total_purchase - $this->total_paid);
    }

    public function getPaymentStatusAttribute(): string
    {
        if ($this->due_amount <= 0)   return 'paid';
        if ($this->total_paid > 0)    return 'partial';
        return 'due';
    }

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', trim($this->name));
        return strtoupper(
            count($words) >= 2 ? $words[0][0] . $words[1][0] : substr($words[0], 0, 2)
        );
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name',    'like', "%{$term}%")
              ->orWhere('phone',   'like', "%{$term}%")
              ->orWhere('address', 'like', "%{$term}%");
        });
    }
}