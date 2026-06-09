<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_price',
        'discount_amount',
        'coupon_code',
        'status',
        'payment_method',

        // ✅ Billing info from checkout form
        'billing_first_name',
        'billing_last_name',
        'billing_email',
        'billing_phone',
        'billing_country',
        'billing_state',
        'billing_zip',
        'billing_address',
        'notes',

        // legacy columns (still in use)
        'address',
        'phone',

        // Stread Fast Courier
        'steadfast_consignment_id',
        'steadfast_tracking_code',

    ];

    protected $casts = [
        'total_price'     => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function returnRequest()
    {
        return $this->hasOne(ReturnRequest::class);
    }

    // ✅ Helper: full billing name
    public function getBillingFullNameAttribute(): string
    {
        return trim(($this->billing_first_name ?? '') . ' ' . ($this->billing_last_name ?? ''));
    }

    // ✅ Helper: nicely formatted billing address
    public function getFullBillingAddressAttribute(): string
    {
        $parts = array_filter([
            $this->billing_address,
            $this->billing_state,
            $this->billing_country,
            $this->billing_zip ? '- ' . $this->billing_zip : null,
        ]);
        return implode(', ', $parts);
    }
}