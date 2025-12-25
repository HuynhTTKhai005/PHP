<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'total_amount_cents',
        'subtotal_cents',
        'shipping_fee_cents',
        'total_discount_cents',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'note',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Quan hệ với user (nếu có đăng nhập)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với chi tiết món
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function coupon()
    {
        return $this->hasOne(OrderCoupon::class);
    }
}
