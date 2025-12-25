<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'min_order_total_amount_cents',
        'max_discount_amount_cents',
        'usage_limit',
        'used_count',
        'is_active',
        'starts_at',
        'expires_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Kiểm tra mã còn hiệu lực không
    public function isValid()
    {
        if (!$this->is_active) return false;

        $now = now();

        if ($this->starts_at && $now->lt($this->starts_at)) return false;
        if ($this->expires_at && $now->gt($this->expires_at)) return false;

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;

        return true;
    }
}