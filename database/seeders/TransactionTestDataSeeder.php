<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Catalog;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Carbon\Carbon;

class TransactionTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing catalogs or create some if none exist
        $catalogs = Catalog::all();
        
        if ($catalogs->isEmpty()) {
            // Create sample fruit catalogs if none exist
            $fruitData = [
                ['id_produk' => 'FRT001', 'nama' => 'Apel', 'harga' => 25000, 'stock' => 100],
                ['id_produk' => 'FRT002', 'nama' => 'Jeruk', 'harga' => 20000, 'stock' => 150],
                ['id_produk' => 'FRT003', 'nama' => 'Pisang', 'harga' => 15000, 'stock' => 200],
                ['id_produk' => 'FRT004', 'nama' => 'Mangga', 'harga' => 30000, 'stock' => 80],
                ['id_produk' => 'FRT005', 'nama' => 'Anggur', 'harga' => 45000, 'stock' => 60],
                ['id_produk' => 'FRT006', 'nama' => 'Strawberry', 'harga' => 35000, 'stock' => 70],
                ['id_produk' => 'FRT007', 'nama' => 'Melon', 'harga' => 40000, 'stock' => 50],
                ['id_produk' => 'FRT008', 'nama' => 'Semangka', 'harga' => 18000, 'stock' => 90],
                ['id_produk' => 'FRT009', 'nama' => 'Durian', 'harga' => 55000, 'stock' => 30],
                ['id_produk' => 'FRT010', 'nama' => 'Rambutan', 'harga' => 22000, 'stock' => 120],
            ];

            foreach ($fruitData as $fruit) {
                Catalog::create([
                    'id_produk' => $fruit['id_produk'],
                    'nama' => $fruit['nama'],
                    'stock' => $fruit['stock'],
                    'keterangan' => 'Buah segar berkualitas tinggi',
                    'harga' => $fruit['harga'],
                    'gambar' => null,
                ]);
            }
            
            $catalogs = Catalog::all();
        }

        // Get admin user for creating transactions
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin Test',
                'email' => 'admin.test@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        // Sample customers
        $customers = [
            ['name' => 'Budi Santoso', 'phone' => '081234567891', 'email' => 'budi@example.com'],
            ['name' => 'Siti Rahayu', 'phone' => '081234567892', 'email' => 'siti@example.com'],
            ['name' => 'Ahmad Wijaya', 'phone' => '081234567893', 'email' => 'ahmad@example.com'],
            ['name' => 'Dewi Lestari', 'phone' => '081234567894', 'email' => 'dewi@example.com'],
            ['name' => 'Rudi Hermawan', 'phone' => '081234567895', 'email' => 'rudi@example.com'],
            ['name' => 'Maya Sari', 'phone' => '081234567896', 'email' => 'maya@example.com'],
            ['name' => 'Andi Pratama', 'phone' => '081234567897', 'email' => 'andi@example.com'],
            ['name' => 'Rina Wati', 'phone' => '081234567898', 'email' => 'rina@example.com'],
            ['name' => 'Joko Susilo', 'phone' => '081234567899', 'email' => 'joko@example.com'],
            ['name' => 'Lina Marlina', 'phone' => '081234567800', 'email' => 'lina@example.com'],
        ];

        $paymentMethods = ['cash', 'transfer', 'card', 'e-wallet'];
        $paymentStatuses = ['paid', 'paid', 'paid', 'pending']; // 75% paid, 25% pending

        // Generate 100 transactions over the last 3 months
        $startDate = Carbon::now()->subMonths(3);
        $endDate = Carbon::now();
        
        $this->command->info('Generating 100 test transactions...');
        
        for ($i = 1; $i <= 100; $i++) {
            // Random date between start and end date
            $transactionDate = Carbon::createFromTimestamp(
                rand($startDate->timestamp, $endDate->timestamp)
            );
            
            // Random customer
            $customer = $customers[array_rand($customers)];
            
            // Generate transaction code
            $transactionCode = 'TRX-' . $transactionDate->format('Ymd') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT);
            
            // Create transaction
            $transaction = Transaction::create([
                'transaction_code' => $transactionCode,
                'customer_name' => $customer['name'],
                'total_amount' => 0, // Will be calculated
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'payment_status' => $paymentStatuses[array_rand($paymentStatuses)],
                'transaction_date' => $transactionDate,
                'notes' => 'Test transaction #' . $i . ' for AI analytics',
                'created_by' => $admin->id,
                'created_at' => $transactionDate,
                'updated_at' => $transactionDate,
            ]);

            // Add 1-4 items per transaction
            $itemsPerTransaction = rand(1, 4);
            $totalAmount = 0;
            $usedCatalogs = [];

            for ($j = 0; $j < $itemsPerTransaction; $j++) {
                // Ensure we don't add the same product twice in one transaction
                do {
                    $catalog = $catalogs->random();
                } while (in_array($catalog->id_produk, $usedCatalogs));
                
                $usedCatalogs[] = $catalog->id_produk;
                
                // Random quantity with higher probability for smaller quantities
                $quantity = $this->getWeightedRandomQuantity();
                $subtotal = $catalog->harga * $quantity;
                $totalAmount += $subtotal;

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'catalog_id_produk' => $catalog->id_produk,
                    'product_name' => $catalog->nama,
                    'quantity' => $quantity,
                    'unit_price' => $catalog->harga,
                    'subtotal' => $subtotal,
                ]);
            }

            // Update transaction total
            $transaction->update(['total_amount' => $totalAmount]);
            
            if ($i % 10 == 0) {
                $this->command->info("Generated {$i}/100 transactions...");
            }
        }

        $this->command->info('✅ Successfully created 100 test transactions!');
        $this->command->info('📊 Data distribution:');
        $this->command->info('   - Date range: ' . $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d'));
        $this->command->info('   - Customers: ' . count($customers) . ' different customers');
        $this->command->info('   - Products: ' . $catalogs->count() . ' different products');
        $this->command->info('   - Payment methods: ' . implode(', ', $paymentMethods));
        $this->command->info('🎯 Ready for AI analytics testing!');
    }

    /**
     * Get weighted random quantity (smaller quantities more likely)
     */
    private function getWeightedRandomQuantity()
    {
        $weights = [
            1 => 40,  // 40% chance for 1 kg
            2 => 25,  // 25% chance for 2 kg
            3 => 15,  // 15% chance for 3 kg
            4 => 10,  // 10% chance for 4 kg
            5 => 5,   // 5% chance for 5 kg
            6 => 3,   // 3% chance for 6 kg
            7 => 1,   // 1% chance for 7 kg
            8 => 1,   // 1% chance for 8 kg
        ];

        $totalWeight = array_sum($weights);
        $random = rand(1, $totalWeight);
        
        $currentWeight = 0;
        foreach ($weights as $quantity => $weight) {
            $currentWeight += $weight;
            if ($random <= $currentWeight) {
                return $quantity;
            }
        }
        
        return 1; // fallback
    }
}
