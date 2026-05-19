<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'product_type',
        'rating',
        'body',
        'status',
        'featured', 
    ];

    // ── Relationships ────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // product_type দেখে সঠিক model return করবে
    public function reviewable()
    {
        if ($this->product_type === 'hotdeal') {
            return $this->belongsTo(HotDeal::class, 'product_id');
        }
        return $this->belongsTo(Product::class, 'product_id');
    }

    // ── Scopes ───────────────────────────────────────────

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // ── Accessors ────────────────────────────────────────

    // rating number থেকে label বের করবে
    public function getRatingLabelAttribute(): string
    {
        return match($this->rating) {
            1 => 'Poor',
            2 => 'Fair',
            3 => 'Good',
            4 => 'Very Good',
            5 => 'Excellent',
            default => '',
        };
    }
}