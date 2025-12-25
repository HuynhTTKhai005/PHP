<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
 
        $categories = [
            ['name' => 'Khai Vị', 'slug' => 'appetizer'],
            ['name' => 'Mì Cay', 'slug' => 'spicy'],
            ['name' => 'Đồ Uống', 'slug' => 'drink'],
            ['name' => 'Lẩu', 'slug' => 'hotpot'],
            ['name' => 'Tokbokki', 'slug' => 'tokbokki'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}