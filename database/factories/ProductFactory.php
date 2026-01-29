<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(5),
            'price' => fake()->randomFloat(2, 10, 5000),
            'image' => fake()->imageUrl(640, 480, 'products'),
            'user_id' => fake()->numberBetween(1, 10),
            'category_id' => fake()->numberBetween(1, 10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}