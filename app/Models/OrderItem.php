<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price_cents',
        'total_cents',
    ];

    // Quan hệ với Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Quan hệ với Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Tự động tính total_cents khi lưu (tùy chọn, tiện lợi)
    protected static function booted()
    {
        static::saving(function ($orderItem) {
            $orderItem->total_cents = $orderItem->quantity * $orderItem->unit_price_cents;
        });
    }
}