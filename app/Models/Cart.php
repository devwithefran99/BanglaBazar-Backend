<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'product_type',  // ✅ যোগ করা হয়েছে
        'quantity'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ FIX: product_type দেখে সঠিক model থেকে লোড করো
    public function product()
    {
        if ($this->product_type === 'hotdeal') {
            return $this->belongsTo(HotDeal::class, 'product_id');
        }

        return $this->belongsTo(Product::class, 'product_id');
    }
}