<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierPayment extends Model
{
    protected $fillable = [
        'supplier_id', 'paid_amount', 'payment_date', 'method', 'note',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'paid_amount'  => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}