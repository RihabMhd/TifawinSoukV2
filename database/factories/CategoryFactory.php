<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Electronics' => 'Latest electronic devices and gadgets',
            'Fashion' => 'Clothing, accessories and fashion items',
            'Home & Garden' => 'Home improvement and gardening products',
            'Books' => 'Books, magazines and reading materials',
            'Sports & Outdoors' => 'Sports equipment and outdoor gear',
            'Toys & Games' => 'Toys, games and entertainment',
            'Health & Beauty' => 'Health and beauty products',
            'Automotive' => 'Auto parts and accessories',
            'Food & Beverages' => 'Food items and beverages',
            'Jewelry' => 'Jewelry and precious accessories',
        ];

        $category = fake()->unique()->randomElement(array_keys($categories));

        return [
            'title' => $category,
            'description' => $categories[$category],
            'user_id' => fake()->numberBetween(1, 10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}