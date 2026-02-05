<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Fournisseur;
use App\Models\User;
use App\Models\Category;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(5),
            'price' => fake()->randomFloat(2, 10, 5000),
            'image' => fake()->imageUrl(640, 480, 'products'),
            'quantity' => fake()->numberBetween(0, 100),
            'user_id' => User::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'fournisseur_id' => Fournisseur::inRandomOrder()->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
