<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Location;
use App\Models\InventoryBatch;
use App\Models\InventoryMovement;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // SEEDER INI HANYA FOKUS MENGISI DATA
        $products = Product::all();
        $locations = Location::all();
        $adminUser = \App\Models\User::first();

        if ($locations->isEmpty()) {
            $this->command->warn('Locations table is empty. Please run LocationSeeder first.');
            return;
        }

        foreach ($products as $product) {
            for ($i = 0; $i < rand(1, 3); $i++) {
                $quantity = rand(50, 200);
                $location = $locations->random();
                $received_date = Carbon::now()->subDays(rand(5, 90));

                $lpn = 'LPN-' . strtoupper(substr(md5($product->id . $i . time()), 0, 8));

                $batch = InventoryBatch::create([
                    'lpn' => $lpn,
                    'product_id' => $product->id,
                    'location_id' => $location->id,
                    'quantity' => $quantity,
                    'received_date' => $received_date,
                    'expiry_date' => (rand(0, 1) == 1) ? $received_date->copy()->addMonths(rand(6, 24)) : null,
                ]);

                InventoryMovement::create([
                    'inventory_batch_id' => $batch->id,
                    'type' => 'INBOUND',
                    'quantity_change' => $quantity,
                    'from_location_id' => null,
                    'to_location_id' => $location->id,
                    'user_id' => $adminUser->id,
                    'notes' => 'Initial stock seeding',
                ]);
            }
        }
    }
}