<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // SEEDER INI HANYA FOKUS MENGISI DATA
        $products = Product::all();
        $adminUser = \App\Models\User::first();
        $customers = ['PT. Maju Jaya', 'CV. Sinar Abadi', 'Toko Kelontong Berkah', 'Distributor Sejahtera', 'Warung Ibu Siti'];

        for ($i = 1; $i <= 15; $i++) {
            $order = Order::create([
                'order_number' => 'SO-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'customer_name' => $customers[array_rand($customers)],
                'status' => 'pending',
                'user_id' => $adminUser->id,
                'notes' => 'Sample order created by seeder.',
                'created_at' => now()->subDays(rand(0, 5)),
                'updated_at' => now()->subDays(rand(0, 5)),
            ]);

            $productSamples = $products->random(rand(1, 4));
            foreach ($productSamples as $product) {
                $order->details()->create([
                    'product_id' => $product->id,
                    'quantity_requested' => rand(1, 10),
                    'quantity_picked' => 0,
                ]);
            }
        }
    }
}