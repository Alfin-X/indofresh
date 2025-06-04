<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Catalog;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Fresh Apples',
                'description' => 'Premium quality red apples, crisp and sweet. Perfect for snacking or cooking.',
                'price' => 25000,
                'stock' => 50,
                'category' => 'Fruits',
                'status' => true,
            ],
            [
                'name' => 'Organic Bananas',
                'description' => 'Naturally ripened organic bananas, rich in potassium and vitamins.',
                'price' => 15000,
                'stock' => 75,
                'category' => 'Fruits',
                'status' => true,
            ],
            [
                'name' => 'Fresh Carrots',
                'description' => 'Crunchy orange carrots, perfect for salads, cooking, or juicing.',
                'price' => 12000,
                'stock' => 40,
                'category' => 'Vegetables',
                'status' => true,
            ],
            [
                'name' => 'Green Lettuce',
                'description' => 'Fresh green lettuce leaves, ideal for salads and sandwiches.',
                'price' => 8000,
                'stock' => 30,
                'category' => 'Vegetables',
                'status' => true,
            ],
            [
                'name' => 'Fresh Milk',
                'description' => 'Pure fresh milk from local farms, rich in calcium and protein.',
                'price' => 18000,
                'stock' => 25,
                'category' => 'Dairy',
                'status' => true,
            ],
            [
                'name' => 'Chicken Breast',
                'description' => 'Lean chicken breast meat, perfect for healthy meals.',
                'price' => 45000,
                'stock' => 20,
                'category' => 'Meat',
                'status' => true,
            ],
            [
                'name' => 'Fresh Salmon',
                'description' => 'Premium Atlantic salmon, rich in omega-3 fatty acids.',
                'price' => 85000,
                'stock' => 15,
                'category' => 'Seafood',
                'status' => true,
            ],
            [
                'name' => 'Orange Juice',
                'description' => 'Freshly squeezed orange juice, no added sugar or preservatives.',
                'price' => 22000,
                'stock' => 35,
                'category' => 'Beverages',
                'status' => true,
            ],
            [
                'name' => 'Fresh Basil',
                'description' => 'Aromatic fresh basil leaves, perfect for cooking and garnishing.',
                'price' => 5000,
                'stock' => 20,
                'category' => 'Herbs',
                'status' => true,
            ],
            [
                'name' => 'Tomatoes',
                'description' => 'Ripe red tomatoes, perfect for salads, cooking, and sauces.',
                'price' => 10000,
                'stock' => 60,
                'category' => 'Vegetables',
                'status' => true,
            ],
            [
                'name' => 'Greek Yogurt',
                'description' => 'Creamy Greek yogurt, high in protein and probiotics.',
                'price' => 28000,
                'stock' => 18,
                'category' => 'Dairy',
                'status' => true,
            ],
            [
                'name' => 'Fresh Strawberries',
                'description' => 'Sweet and juicy strawberries, perfect for desserts or snacking.',
                'price' => 35000,
                'stock' => 25,
                'category' => 'Fruits',
                'status' => true,
            ],
            [
                'name' => 'Broccoli',
                'description' => 'Fresh green broccoli, packed with vitamins and minerals.',
                'price' => 14000,
                'stock' => 30,
                'category' => 'Vegetables',
                'status' => true,
            ],
            [
                'name' => 'Ground Beef',
                'description' => 'Premium ground beef, perfect for burgers, meatballs, and more.',
                'price' => 55000,
                'stock' => 12,
                'category' => 'Meat',
                'status' => true,
            ],
            [
                'name' => 'Fresh Shrimp',
                'description' => 'Large fresh shrimp, perfect for seafood dishes.',
                'price' => 75000,
                'stock' => 10,
                'category' => 'Seafood',
                'status' => true,
            ],
            [
                'name' => 'Mineral Water',
                'description' => 'Pure mineral water, refreshing and healthy.',
                'price' => 8000,
                'stock' => 100,
                'category' => 'Beverages',
                'status' => true,
            ],
            [
                'name' => 'Fresh Parsley',
                'description' => 'Fresh parsley leaves, great for garnishing and cooking.',
                'price' => 4000,
                'stock' => 25,
                'category' => 'Herbs',
                'status' => true,
            ],
            [
                'name' => 'Cheddar Cheese',
                'description' => 'Aged cheddar cheese, rich and flavorful.',
                'price' => 42000,
                'stock' => 15,
                'category' => 'Dairy',
                'status' => true,
            ],
            [
                'name' => 'Oranges',
                'description' => 'Sweet and juicy oranges, high in vitamin C.',
                'price' => 20000,
                'stock' => 45,
                'category' => 'Fruits',
                'status' => true,
            ],
            [
                'name' => 'Bell Peppers',
                'description' => 'Colorful bell peppers, perfect for stir-fries and salads.',
                'price' => 16000,
                'stock' => 35,
                'category' => 'Vegetables',
                'status' => true,
            ],
        ];

        foreach ($products as $product) {
            Catalog::create($product);
        }
    }
}
