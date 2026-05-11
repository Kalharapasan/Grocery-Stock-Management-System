<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@grocery.com',
        ]);

        // Create categories
        $categories = [
            ['name' => 'Fruits', 'description' => 'Fresh fruits and seasonal produce'],
            ['name' => 'Vegetables', 'description' => 'Fresh vegetables and greens'],
            ['name' => 'Dairy', 'description' => 'Milk, cheese, yogurt and dairy products'],
            ['name' => 'Beverages', 'description' => 'Drinks, juices, water and soft drinks'],
            ['name' => 'Snacks', 'description' => 'Chips, biscuits, chocolates and snacks'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Create products
        $products = [
            ['category_id' => 1, 'name' => 'Apple', 'sku' => 'FRT-001', 'unit' => 'kg', 'price' => 350, 'cost_price' => 280, 'current_stock' => 50, 'low_stock_threshold' => 10],
            ['category_id' => 1, 'name' => 'Banana', 'sku' => 'FRT-002', 'unit' => 'dozen', 'price' => 180, 'cost_price' => 120, 'current_stock' => 30, 'low_stock_threshold' => 8],
            ['category_id' => 1, 'name' => 'Orange', 'sku' => 'FRT-003', 'unit' => 'kg', 'price' => 280, 'cost_price' => 200, 'current_stock' => 5, 'low_stock_threshold' => 10],
            ['category_id' => 2, 'name' => 'Carrot', 'sku' => 'VEG-001', 'unit' => 'kg', 'price' => 120, 'cost_price' => 80, 'current_stock' => 40, 'low_stock_threshold' => 15],
            ['category_id' => 2, 'name' => 'Tomato', 'sku' => 'VEG-002', 'unit' => 'kg', 'price' => 100, 'cost_price' => 60, 'current_stock' => 3, 'low_stock_threshold' => 10],
            ['category_id' => 2, 'name' => 'Potato', 'sku' => 'VEG-003', 'unit' => 'kg', 'price' => 80, 'cost_price' => 50, 'current_stock' => 100, 'low_stock_threshold' => 20],
            ['category_id' => 3, 'name' => 'Fresh Milk 1L', 'sku' => 'DRY-001', 'unit' => 'pcs', 'price' => 220, 'cost_price' => 180, 'current_stock' => 25, 'low_stock_threshold' => 10],
            ['category_id' => 3, 'name' => 'Cheddar Cheese', 'sku' => 'DRY-002', 'unit' => 'pcs', 'price' => 450, 'cost_price' => 350, 'current_stock' => 8, 'low_stock_threshold' => 5],
            ['category_id' => 3, 'name' => 'Yogurt Cup', 'sku' => 'DRY-003', 'unit' => 'pcs', 'price' => 85, 'cost_price' => 55, 'current_stock' => 2, 'low_stock_threshold' => 10],
            ['category_id' => 4, 'name' => 'Mineral Water 1.5L', 'sku' => 'BEV-001', 'unit' => 'pcs', 'price' => 90, 'cost_price' => 50, 'current_stock' => 60, 'low_stock_threshold' => 20],
            ['category_id' => 4, 'name' => 'Orange Juice 1L', 'sku' => 'BEV-002', 'unit' => 'pcs', 'price' => 320, 'cost_price' => 240, 'current_stock' => 15, 'low_stock_threshold' => 8],
            ['category_id' => 5, 'name' => 'Potato Chips', 'sku' => 'SNK-001', 'unit' => 'pack', 'price' => 150, 'cost_price' => 100, 'current_stock' => 45, 'low_stock_threshold' => 15],
            ['category_id' => 5, 'name' => 'Chocolate Bar', 'sku' => 'SNK-002', 'unit' => 'pcs', 'price' => 200, 'cost_price' => 140, 'current_stock' => 4, 'low_stock_threshold' => 10],
            ['category_id' => 5, 'name' => 'Biscuit Pack', 'sku' => 'SNK-003', 'unit' => 'pack', 'price' => 120, 'cost_price' => 75, 'current_stock' => 35, 'low_stock_threshold' => 12],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
