<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop Pro 15"',
                'price' => 1299.99,
                'stock_quantity' => 15,
                'description' => 'High-performance laptop with 16GB RAM and 512GB SSD',
            ],
            [
                'name' => 'Wireless Mouse',
                'price' => 29.99,
                'stock_quantity' => 3, // Low stock
                'description' => 'Ergonomic wireless mouse with long battery life',
            ],
            [
                'name' => 'Mechanical Keyboard',
                'price' => 89.99,
                'stock_quantity' => 25,
                'description' => 'RGB mechanical keyboard with blue switches',
            ],
            [
                'name' => 'USB-C Hub',
                'price' => 49.99,
                'stock_quantity' => 2, // Low stock
                'description' => '7-in-1 USB-C hub with multiple ports',
            ],
            [
                'name' => 'Webcam HD 1080p',
                'price' => 79.99,
                'stock_quantity' => 12,
                'description' => 'High definition webcam for video conferences',
            ],
            [
                'name' => 'Monitor 27" 4K',
                'price' => 449.99,
                'stock_quantity' => 8,
                'description' => '27-inch 4K IPS monitor with HDR support',
            ],
            [
                'name' => 'Desk Lamp LED',
                'price' => 39.99,
                'stock_quantity' => 20,
                'description' => 'Adjustable LED desk lamp with touch controls',
            ],
            [
                'name' => 'Headphones Wireless',
                'price' => 199.99,
                'stock_quantity' => 4, // Low stock
                'description' => 'Noise-cancelling wireless headphones',
            ],
            [
                'name' => 'External SSD 1TB',
                'price' => 129.99,
                'stock_quantity' => 18,
                'description' => 'Portable external SSD with fast transfer speeds',
            ],
            [
                'name' => 'Phone Stand',
                'price' => 19.99,
                'stock_quantity' => 30,
                'description' => 'Adjustable phone stand for desk',
            ],
            [
                'name' => 'Cable Organizer',
                'price' => 14.99,
                'stock_quantity' => 1, // Low stock
                'description' => 'Cable management system for desk',
            ],
            [
                'name' => 'Laptop Bag',
                'price' => 59.99,
                'stock_quantity' => 22,
                'description' => 'Padded laptop bag with multiple compartments',
            ],
            [
                'name' => 'Portable Charger',
                'price' => 34.99,
                'stock_quantity' => 16,
                'description' => 'High-capacity portable power bank',
            ],
            [
                'name' => 'Screen Protector',
                'price' => 9.99,
                'stock_quantity' => 50,
                'description' => 'Tempered glass screen protector',
            ],
            [
                'name' => 'Bluetooth Speaker',
                'price' => 69.99,
                'stock_quantity' => 14,
                'description' => 'Portable Bluetooth speaker with 360-degree sound',
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
