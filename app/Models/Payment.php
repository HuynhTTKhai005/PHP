<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'amount_cents',
        'transaction_code',
        'status',
        'payment_date',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'amount_cents' => 'integer',
    ];

    // Quan hệ với Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
