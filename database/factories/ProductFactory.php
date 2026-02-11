<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Fournisseur;
use App\Models\User;
use App\Models\Category;

class ProductFactory extends Factory
{
    private array $products = [
        // Electronics
        ['title' => 'iPhone 15 Pro Max', 'description' => 'Latest Apple flagship smartphone with titanium design, A17 Pro chip, advanced camera system with 5x optical zoom, and USB-C port. Features 6.7-inch Super Retina XDR display.', 'price' => 1199.99, 'category' => 'Electronics'],
        ['title' => 'Samsung Galaxy S24 Ultra', 'description' => 'Premium Android smartphone with 200MP camera, S Pen support, 6.8-inch Dynamic AMOLED display, Snapdragon 8 Gen 3 processor, and titanium frame.', 'price' => 1299.99, 'category' => 'Electronics'],
        ['title' => 'MacBook Pro 16-inch M3', 'description' => 'Powerful laptop with Apple M3 chip, 16GB RAM, 512GB SSD, stunning Liquid Retina XDR display, and up to 22 hours battery life.', 'price' => 2499.00, 'category' => 'Electronics'],
        ['title' => 'Sony WH-1000XM5', 'description' => 'Industry-leading noise canceling wireless headphones with exceptional sound quality, 30-hour battery life, and premium comfort.', 'price' => 399.99, 'category' => 'Electronics'],
        ['title' => 'iPad Air 11-inch', 'description' => 'Versatile tablet with M2 chip, stunning display, Apple Pencil Pro support, perfect for creativity and productivity.', 'price' => 599.00, 'category' => 'Electronics'],
        
        // Home & Kitchen
        ['title' => 'Dyson V15 Detect', 'description' => 'Cordless vacuum cleaner with laser dust detection, powerful suction, and intelligent cleaning modes. Perfect for all floor types.', 'price' => 649.99, 'category' => 'Home & Kitchen'],
        ['title' => 'Ninja Foodi Air Fryer', 'description' => '6-in-1 air fryer with 8-quart capacity, dual baskets, and multiple cooking functions including roast, bake, and dehydrate.', 'price' => 179.99, 'category' => 'Home & Kitchen'],
        ['title' => 'Nespresso Vertuo Plus', 'description' => 'Premium coffee maker with centrifusion technology, one-touch brewing, and barcode scanning for perfect coffee every time.', 'price' => 189.00, 'category' => 'Home & Kitchen'],
        ['title' => 'KitchenAid Stand Mixer', 'description' => 'Professional-grade 5-quart stand mixer with 10 speeds, tilt-head design, and multiple attachments included.', 'price' => 379.99, 'category' => 'Home & Kitchen'],
        
        // Fashion
        ['title' => 'Nike Air Max 270', 'description' => 'Iconic sneakers with Max Air cushioning, breathable mesh upper, and sleek design. Perfect for everyday wear and light exercise.', 'price' => 150.00, 'category' => 'Fashion'],
        ['title' => 'Levi\'s 501 Original Jeans', 'description' => 'Classic straight-fit jeans with button fly, made from premium denim. Timeless style that never goes out of fashion.', 'price' => 89.99, 'category' => 'Fashion'],
        ['title' => 'Ray-Ban Aviator Sunglasses', 'description' => 'Iconic aviator sunglasses with UV protection, metal frame, and classic teardrop shape. Available in multiple lens colors.', 'price' => 154.00, 'category' => 'Fashion'],
        ['title' => 'North Face Puffer Jacket', 'description' => 'Warm insulated jacket with water-resistant finish, adjustable hood, and multiple pockets. Perfect for cold weather.', 'price' => 229.00, 'category' => 'Fashion'],
        
        // Sports & Outdoors
        ['title' => 'Yeti Rambler Tumbler 30oz', 'description' => 'Insulated stainless steel tumbler keeps drinks cold for 24 hours or hot for 6 hours. Dishwasher safe with MagSlider lid.', 'price' => 39.99, 'category' => 'Sports'],
        ['title' => 'Fitbit Charge 6', 'description' => 'Advanced fitness tracker with heart rate monitoring, GPS, sleep tracking, and 7+ day battery life. Water resistant up to 50m.', 'price' => 159.95, 'category' => 'Sports'],
        ['title' => 'Hydro Flask Water Bottle 32oz', 'description' => 'Double-wall vacuum insulated water bottle keeps beverages cold for 24 hours. BPA-free with wide mouth opening.', 'price' => 44.95, 'category' => 'Sports'],
        
        // Books & Media
        ['title' => 'Kindle Paperwhite', 'description' => 'Waterproof e-reader with 6.8-inch glare-free display, adjustable warm light, and weeks of battery life. Holds thousands of books.', 'price' => 139.99, 'category' => 'Books'],
        ['title' => 'Bose SoundLink Mini II', 'description' => 'Portable Bluetooth speaker with deep bass, 12-hour battery, and premium aluminum design. Perfect for music on the go.', 'price' => 199.00, 'category' => 'Electronics'],
        
        // Beauty & Personal Care
        ['title' => 'Oral-B iO Series 9', 'description' => 'Smart electric toothbrush with AI recognition, 7 brushing modes, magnetic charger, and pressure sensor for optimal cleaning.', 'price' => 279.99, 'category' => 'Personal Care'],
        ['title' => 'Philips Norelco OneBlade', 'description' => 'Hybrid trimmer and shaver for face and body, wet & dry use, rechargeable battery, and dual-sided blade technology.', 'price' => 49.99, 'category' => 'Personal Care'],
    ];

    public function definition(): array
    {
        $product = fake()->randomElement($this->products);
        
        return [
            'title' => $product['title'],
            'description' => $product['description'],
            'price' => $product['price'],
            'image' => 'https://placehold.co/640x480/png?text=' . urlencode($product['title']),
            'quantity' => fake()->numberBetween(5, 100),
            'user_id' => User::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'fournisseur_id' => Fournisseur::inRandomOrder()->first()->id,
            'stock_alert_threshold' => fake()->numberBetween(5, 15),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}