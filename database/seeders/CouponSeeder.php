<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Coupon::create([
            'code' => 'GIAM50K',
            'description' => 'Giảm 50.000đ cho đơn từ 300.000đ',
            'discount_type' => 'fixed',
            'discount_value' => 500000,  
            'min_order_total_amount_cents' => 300000,  
            'max_discount_amount_cents' => null,
            'usage_limit' => 100,
            'used_count' => 0,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(3),
        ]);

        \App\Models\Coupon::create([
            'code' => 'GIAM20%',
            'description' => 'Giảm 20% tối đa 100.000đ cho đơn từ 500.000đ',
            'discount_type' => 'percent',
            'discount_value' => 20,
            'min_order_total_amount_cents' => 500000, 
            'max_discount_amount_cents' => 100000,  
            'usage_limit' => 50,
            'used_count' => 0,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addMonth(),
        ]);

        \App\Models\Coupon::create([
            'code' => 'FREESHIP',
            'description' => 'Miễn phí vận chuyển cho đơn từ 200.000đ',
            'discount_type' => 'fixed',
            'discount_value' => 30000,  
            'min_order_total_amount_cents' => 200000,
            'max_discount_amount_cents' => null,
            'usage_limit' => null,
            'used_count' => 0,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => null,
        ]);
    }
}