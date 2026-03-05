<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('products')->truncate();

        $data = json_decode(
            file_get_contents(database_path('data/menuData.json')),
            true
        );

        foreach ($data as $item) {

            $categoryMap = [
                'appetizer' => 1,
                'spicy' => 2,
                'drink' => 3,
                'hotpot' => 4,
                'tokbokki' => 5,
            ];

            DB::table('products')->insert([
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'description' => $item['description'],
                'base_price_cents' => $item['price'],
                'image_url' => 'assets/images/menu/'.basename($item['image']),
                'type' => $item['category'] === 'drink' ? 'drink' : 'food',
                'category_id' => $categoryMap[$item['category']] ?? 1,
                'is_spicy' => $item['category'] === 'spicy',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
