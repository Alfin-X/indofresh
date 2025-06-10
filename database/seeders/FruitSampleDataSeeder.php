<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Catalog;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Carbon\Carbon;

class FruitSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create fruit catalogs
        $fruits = [
            ['name' => 'Apel Malang', 'category' => 'Buah Segar', 'price' => 25000, 'stock' => 50],
            ['name' => 'Jeruk Pontianak', 'category' => 'Buah Segar', 'price' => 20000, 'stock' => 40],
            ['name' => 'Pisang Cavendish', 'category' => 'Buah Segar', 'price' => 15000, 'stock' => 60],
            ['name' => 'Mangga Harum Manis', 'category' => 'Buah Segar', 'price' => 30000, 'stock' => 35],
            ['name' => 'Anggur Hijau', 'category' => 'Buah Import', 'price' => 45000, 'stock' => 25],
            ['name' => 'Strawberry Segar', 'category' => 'Buah Import', 'price' => 35000, 'stock' => 30],
            ['name' => 'Melon Golden', 'category' => 'Buah Segar', 'price' => 40000, 'stock' => 20],
            ['name' => 'Semangka Merah', 'category' => 'Buah Segar', 'price' => 18000, 'stock' => 45],
        ];

        $fruitCatalogs = [];
        foreach ($fruits as $fruit) {
            $catalog = Catalog::create([
                'name' => $fruit['name'],
                'description' => 'Buah segar berkualitas tinggi, dipetik langsung dari kebun.',
                'price' => $fruit['price'],
                'stock' => $fruit['stock'],
                'category' => $fruit['category'],
                'status' => true,
            ]);
            $fruitCatalogs[] = $catalog;
        }

        // Get admin user for creating transactions
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin Test',
                'email' => 'admin.test@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'phone' => '081234567890',
                'address' => 'Test Address'
            ]);
        }

        // Create sample transactions for the last 30 days
        $customers = [
            ['name' => 'Budi Santoso', 'phone' => '081234567891', 'email' => 'budi@example.com'],
            ['name' => 'Siti Rahayu', 'phone' => '081234567892', 'email' => 'siti@example.com'],
            ['name' => 'Ahmad Wijaya', 'phone' => '081234567893', 'email' => 'ahmad@example.com'],
            ['name' => 'Dewi Lestari', 'phone' => '081234567894', 'email' => 'dewi@example.com'],
            ['name' => 'Rudi Hermawan', 'phone' => '081234567895', 'email' => 'rudi@example.com'],
        ];

        $paymentMethods = ['cash', 'transfer', 'card', 'e-wallet'];

        // Generate transactions for last 30 days
        for ($day = 30; $day >= 1; $day--) {
            $date = Carbon::now()->subDays($day);
            
            // Generate 1-5 transactions per day
            $transactionsPerDay = rand(1, 5);
            
            for ($i = 0; $i < $transactionsPerDay; $i++) {
                $customer = $customers[array_rand($customers)];
                $transactionDate = $date->copy()->addHours(rand(8, 20))->addMinutes(rand(0, 59));
                
                // Create transaction
                $transaction = Transaction::create([
                    'transaction_code' => 'TRX-' . $transactionDate->format('Ymd') . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                    'customer_name' => $customer['name'],
                    'customer_phone' => $customer['phone'],
                    'customer_email' => $customer['email'],
                    'total_amount' => 0, // Will be calculated
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'payment_status' => 'paid',
                    'transaction_date' => $transactionDate,
                    'notes' => 'Sample transaction for AI testing',
                    'created_by' => $admin->id,
                    'created_at' => $transactionDate,
                    'updated_at' => $transactionDate,
                ]);

                // Add 1-3 fruit items per transaction
                $itemsPerTransaction = rand(1, 3);
                $totalAmount = 0;

                for ($j = 0; $j < $itemsPerTransaction; $j++) {
                    $fruit = $fruitCatalogs[array_rand($fruitCatalogs)];
                    $quantity = rand(1, 5);
                    $subtotal = $fruit->price * $quantity;
                    $totalAmount += $subtotal;

                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'catalog_id' => $fruit->id,
                        'product_name' => $fruit->name,
                        'quantity' => $quantity,
                        'unit_price' => $fruit->price,
                        'subtotal' => $subtotal,
                    ]);
                }

                // Update transaction total
                $transaction->update(['total_amount' => $totalAmount]);
            }
        }

        $this->command->info('Sample fruit transaction data created successfully!');
        $this->command->info('Created ' . count($fruitCatalogs) . ' fruit products');
        $this->command->info('Generated transactions for the last 30 days');
    }
}
