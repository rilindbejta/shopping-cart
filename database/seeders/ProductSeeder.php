<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get categories
        $electronics = Category::where('slug', 'electronics')->first();
        $clothing = Category::where('slug', 'clothing')->first();
        $homeGarden = Category::where('slug', 'home-garden')->first();
        $sports = Category::where('slug', 'sports-outdoors')->first();
        $books = Category::where('slug', 'books')->first();

        $products = [
            [
                'name' => 'Laptop Pro 15"',
                'price' => 1299.99,
                'stock_quantity' => 15,
                'description' => 'High-performance laptop with 16GB RAM and 512GB SSD',
                'category_id' => $electronics?->id,
                'image_url' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=400&fit=crop',
            ],
            [
                'name' => 'Wireless Mouse',
                'price' => 29.99,
                'stock_quantity' => 3,
                'description' => 'Ergonomic wireless mouse with long battery life',
                'category_id' => $electronics?->id,
                'image_url' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=400&h=400&fit=crop',
            ],
            [
                'name' => 'Mechanical Keyboard',
                'price' => 89.99,
                'stock_quantity' => 25,
                'description' => 'RGB mechanical keyboard with blue switches',
                'category_id' => $electronics?->id,
                'image_url' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=400&h=400&fit=crop',
            ],
            [
                'name' => 'USB-C Hub',
                'price' => 49.99,
                'stock_quantity' => 2,
                'description' => '7-in-1 USB-C hub with multiple ports',
                'category_id' => $electronics?->id,
                'image_url' => 'https://images.unsplash.com/photo-1625948515291-69613efd103f?w=400&h=400&fit=crop',
            ],
            [
                'name' => 'Webcam HD 1080p',
                'price' => 79.99,
                'stock_quantity' => 12,
                'description' => 'High definition webcam for video conferences',
                'category_id' => $electronics?->id,
                'image_url' => 'https://images.unsplash.com/photo-1587334207073-fb9ddc917fb1?w=400&h=400&fit=crop',
            ],
            [
                'name' => 'Monitor 27" 4K',
                'price' => 449.99,
                'stock_quantity' => 8,
                'description' => '27-inch 4K IPS monitor with HDR support',
                'category_id' => $electronics?->id,
                'image_url' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=400&h=400&fit=crop',
            ],
            [
                'name' => 'Desk Lamp LED',
                'price' => 39.99,
                'stock_quantity' => 20,
                'description' => 'Adjustable LED desk lamp with touch controls',
                'category_id' => $homeGarden?->id,
                'image_url' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=400&h=400&fit=crop',
            ],
            [
                'name' => 'Headphones Wireless',
                'price' => 199.99,
                'stock_quantity' => 4,
                'description' => 'Noise-cancelling wireless headphones',
                'category_id' => $electronics?->id,
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=400&fit=crop',
            ],
            [
                'name' => 'External SSD 1TB',
                'price' => 129.99,
                'stock_quantity' => 18,
                'description' => 'Portable external SSD with fast transfer speeds',
                'category_id' => $electronics?->id,
                'image_url' => 'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=400&h=400&fit=crop',
            ],
            [
                'name' => 'Running Shoes',
                'price' => 89.99,
                'stock_quantity' => 30,
                'description' => 'Lightweight running shoes with excellent cushioning',
                'category_id' => $sports?->id,
                'image_url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=400&fit=crop',
            ],
            [
                'name' => 'Yoga Mat',
                'price' => 34.99,
                'stock_quantity' => 25,
                'description' => 'Non-slip yoga mat with carrying strap',
                'category_id' => $sports?->id,
                'image_url' => 'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?w=400&h=400&fit=crop',
            ],
            [
                'name' => 'Winter Jacket',
                'price' => 159.99,
                'stock_quantity' => 12,
                'description' => 'Warm winter jacket with hood',
                'category_id' => $clothing?->id,
                'image_url' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=400&h=400&fit=crop',
            ],
            [
                'name' => 'Cotton T-Shirt',
                'price' => 24.99,
                'stock_quantity' => 50,
                'description' => '100% cotton comfortable t-shirt',
                'category_id' => $clothing?->id,
                'image_url' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop',
            ],
            [
                'name' => 'Coffee Maker',
                'price' => 79.99,
                'stock_quantity' => 14,
                'description' => 'Programmable coffee maker with thermal carafe',
                'category_id' => $homeGarden?->id,
                'image_url' => 'https://images.unsplash.com/photo-1517668808822-9ebb02f2a0e6?w=400&h=400&fit=crop',
            ],
            [
                'name' => 'Plant Pot Set',
                'price' => 29.99,
                'stock_quantity' => 35,
                'description' => 'Set of 3 ceramic plant pots with drainage',
                'category_id' => $homeGarden?->id,
                'image_url' => 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?w=400&h=400&fit=crop',
            ],
            [
                'name' => 'Programming Book',
                'price' => 49.99,
                'stock_quantity' => 20,
                'description' => 'Comprehensive guide to modern programming',
                'category_id' => $books?->id,
                'image_url' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=400&h=400&fit=crop',
            ],
            [
                'name' => 'Cooking Essentials',
                'price' => 39.99,
                'stock_quantity' => 18,
                'description' => 'Complete guide to cooking basics',
                'category_id' => $books?->id,
                'image_url' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400&h=400&fit=crop',
            ],
            [
                'name' => 'Backpack 40L',
                'price' => 69.99,
                'stock_quantity' => 22,
                'description' => 'Durable hiking backpack with rain cover',
                'category_id' => $sports?->id,
                'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=400&fit=crop',
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}
