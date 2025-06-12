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
                'id_produk' => 'PRD001',
                'nama' => 'Fresh Apples',
                'stock' => 50,
                'keterangan' => 'Apel segar berkualitas premium',
                'harga' => 25000,
                'gambar' => null,
            ],
            [
                'id_produk' => 'PRD002',
                'nama' => 'Organic Bananas',
                'stock' => 75,
                'keterangan' => 'Pisang organik matang alami',
                'harga' => 15000,
                'gambar' => null,
            ],
            [
                'id_produk' => 'PRD003',
                'nama' => 'Fresh Carrots',
                'stock' => 40,
                'keterangan' => 'Wortel segar untuk salad dan jus',
                'harga' => 12000,
                'gambar' => null,
            ],
            [
                'id_produk' => 'PRD004',
                'nama' => 'Green Lettuce',
                'stock' => 30,
                'keterangan' => 'Selada hijau segar untuk salad',
                'harga' => 8000,
                'gambar' => null,
            ],
            [
                'id_produk' => 'PRD005',
                'nama' => 'Fresh Milk',
                'stock' => 25,
                'keterangan' => 'Susu segar dari peternakan lokal',
                'harga' => 18000,
                'gambar' => null,
            ],
            [
                'id_produk' => 'PRD006',
                'nama' => 'Chicken Breast',
                'stock' => 20,
                'keterangan' => 'Dada ayam tanpa lemak berkualitas',
                'harga' => 45000,
                'gambar' => null,
            ],
            [
                'id_produk' => 'PRD007',
                'nama' => 'Fresh Salmon',
                'stock' => 15,
                'keterangan' => 'Salmon atlantik segar kaya omega-3',
                'harga' => 85000,
                'gambar' => null,
            ],
            [
                'id_produk' => 'PRD008',
                'nama' => 'Orange Juice',
                'stock' => 35,
                'keterangan' => 'Jus jeruk segar tanpa pengawet',
                'harga' => 22000,
                'gambar' => null,
            ],
            [
                'id_produk' => 'PRD009',
                'nama' => 'Fresh Basil',
                'stock' => 20,
                'keterangan' => 'Daun kemangi segar untuk masakan',
                'harga' => 5000,
                'gambar' => null,
            ],
            [
                'id_produk' => 'PRD010',
                'nama' => 'Tomatoes',
                'stock' => 60,
                'keterangan' => 'Tomat merah matang untuk masakan',
                'harga' => 10000,
                'gambar' => null,
            ],
            [
                'id_produk' => 'PRD011',
                'nama' => 'Greek Yogurt',
                'stock' => 25,
                'keterangan' => 'Yogurt Yunani kaya protein',
                'harga' => 28000,
                'gambar' => null,
            ],
            [
                'id_produk' => 'PRD012',
                'nama' => 'Fresh Strawberries',
                'stock' => 30,
                'keterangan' => 'Stroberi segar manis dan berair',
                'harga' => 35000,
                'gambar' => null,
            ],
            [
                'id_produk' => 'PRD013',
                'nama' => 'Broccoli',
                'stock' => 40,
                'keterangan' => 'Brokoli hijau segar kaya vitamin',
                'harga' => 14000,
                'gambar' => null,
            ],
            [
                'id_produk' => 'PRD014',
                'nama' => 'Ground Beef',
                'stock' => 15,
                'keterangan' => 'Daging sapi giling berkualitas',
                'harga' => 55000,
                'gambar' => null,
            ],
            [
                'id_produk' => 'PRD015',
                'nama' => 'Fresh Shrimp',
                'stock' => 20,
                'keterangan' => 'Udang segar dari laut',
                'harga' => 75000,
                'gambar' => null,
            ],
        ];

        foreach ($products as $product) {
            Catalog::create($product);
        }
    }
}
