<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'title' => 'Electronics',
                'description' => 'Latest electronic devices, smartphones, laptops, and gadgets',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Fashion',
                'description' => 'Clothing, shoes, accessories and fashion items for men and women',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Home & Garden',
                'description' => 'Home improvement, furniture, decor and gardening products',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Books',
                'description' => 'Books, magazines, educational materials and reading resources',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sports & Outdoors',
                'description' => 'Sports equipment, outdoor gear, fitness and camping products',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Toys & Games',
                'description' => 'Toys, games, educational toys and entertainment for children',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Health & Beauty',
                'description' => 'Health products, cosmetics, skincare and beauty items',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Automotive',
                'description' => 'Auto parts, accessories, tools and car care products',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Food & Beverages',
                'description' => 'Food items, beverages, snacks and specialty foods',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Jewelry',
                'description' => 'Jewelry, watches, precious accessories and gift items',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}