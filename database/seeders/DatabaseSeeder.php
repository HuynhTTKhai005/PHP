<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;  // Bỏ dòng này nếu muốn thấy tiến trình

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Tạo user admin/test (dùng firstOrCreate để tránh duplicate)
        \App\Models\User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'), // hoặc để trống nếu dùng Sanctum
            ]
        );

        // 2. Chạy các seeder theo thứ tự hợp lý
        $this->call([
            CategorySeeder::class,   // ← Quan trọng: Phải có trước Product
            ProductSeeder::class,
            CouponSeeder::class,     // Nếu bạn đã có, thêm vào đây
            // Thêm các seeder khác sau này ở đây
        ]);
    }
}