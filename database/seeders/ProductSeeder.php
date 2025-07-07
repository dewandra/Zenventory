<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // SEEDER INI HANYA FOKUS MENGISI DATA
        $products = [
            // Data produk Anda... (tidak perlu saya tulis ulang, biarkan seperti yang ada)
            // Makanan & Minuman
            ['sku' => 'FNB-001', 'name' => 'Indomie Goreng Original', 'description' => 'Mi instan goreng rasa original, 85g.'],
            ['sku' => 'FNB-002', 'name' => 'Teh Botol Sosro Kotak', 'description' => 'Minuman teh melati dalam kemasan kotak 250ml.'],
            ['sku' => 'FNB-003', 'name' => 'Biskuit Roma Kelapa', 'description' => 'Biskuit renyah dengan rasa kelapa, 300g.'],
            ['sku' => 'FNB-004', 'name' => 'Susu Ultra Milk Coklat', 'description' => 'Susu UHT rasa coklat, 1L.'],
            ['sku' => 'FNB-005', 'name' => 'Kopi Kapal Api Special Mix', 'description' => 'Kopi instan dengan gula, 10 sachet.'],

            // Elektronik
            ['sku' => 'ELC-001', 'name' => 'Mouse Logitech M220 Silent', 'description' => 'Mouse wireless silent click, warna hitam.'],
            ['sku' => 'ELC-002', 'name' => 'Keyboard Mechanical Rexus Daxa M84', 'description' => 'Keyboard mechanical TKL dengan RGB.'],
            ['sku' => 'ELC-003', 'name' => 'Flashdisk Sandisk 64GB', 'description' => 'USB 3.0 Flash Drive 64GB.'],
            ['sku' => 'ELC-004', 'name' => 'Power Bank Anker PowerCore 10000', 'description' => 'Kapasitas 10000mAh, output 2.4A.'],
            ['sku' => 'ELC-005', 'name' => 'HDMI Cable 2M', 'description' => 'Kabel HDMI v2.0, panjang 2 meter.'],

            // Alat Tulis Kantor
            ['sku' => 'ATK-001', 'name' => 'Kertas HVS A4 80gsm', 'description' => 'Satu rim kertas HVS ukuran A4, 80 gsm.'],
            ['sku' => 'ATK-002', 'name' => 'Pulpen Standard AE7 Hitam', 'description' => 'Paket 12 pulpen tinta hitam.'],
            ['sku' => 'ATK-003', 'name' => 'Buku Tulis Sinar Dunia 58 lbr', 'description' => 'Paket 10 buku tulis, 58 lembar.'],
            ['sku' => 'ATK-004', 'name' => 'Spidol Snowman Board Marker Hitam', 'description' => 'Spidol untuk papan tulis putih.'],
            ['sku' => 'ATK-005', 'name' => 'Tipe-X Kertas Joyko', 'description' => 'Correction tape / tipe-x kertas.'],

            // Perawatan Diri
            ['sku' => 'PC-001', 'name' => 'Sabun Mandi Lifebuoy Total 10', 'description' => 'Sabun batang anti-bakteri, 85g.'],
            ['sku' => 'PC-002', 'name' => 'Shampoo Clear Men Cool Sport', 'description' => 'Shampoo anti ketombe pria, 160ml.'],
            ['sku' => 'PC-003', 'name' => 'Pasta Gigi Pepsodent Whitening', 'description' => 'Pasta gigi pemutih, 190g.'],
            ['sku' => 'PC-004', 'name' => 'Deodorant Rexona Men Ice Cool', 'description' => 'Roll-on deodorant untuk pria, 45ml.'],
            ['sku' => 'PC-005', 'name' => 'Pembersih Muka Garnier Men', 'description' => 'Pembersih muka pria untuk kulit berminyak.'],
            
            // Produk Tambahan
            ['sku' => 'GEN-001', 'name' => 'Lampu LED Philips 12W', 'description' => 'Bohlam lampu LED 12 Watt, warna putih.'],
            ['sku' => 'GEN-002', 'name' => 'Baterai ABC Alkaline AA', 'description' => 'Paket isi 4 baterai AA.'],
            ['sku' => 'GEN-003', 'name' => 'Tisu Wajah Paseo Smart', 'description' => 'Tisu wajah 250 lembar.'],
            ['sku' => 'GEN-004', 'name' => 'Sandal Jepit Swallow', 'description' => 'Sandal jepit karet, ukuran 10.5.'],
            ['sku' => 'GEN-005', 'name' => 'Payung Lipat Otomatis', 'description' => 'Payung lipat dengan tombol buka-tutup.'],
            ['sku' => 'HMD-001', 'name' => 'Pembersih Lantai Wipol Karbol', 'description' => 'Cairan pembersih lantai dengan disinfektan, 780ml.'],
            ['sku' => 'HMD-002', 'name' => 'Deterjen Rinso Anti Noda', 'description' => 'Deterjen bubuk, 1.8kg.'],
            ['sku' => 'HMD-003', 'name' => 'Pewangi Pakaian Molto', 'description' => 'Pewangi dan pelembut pakaian, 820ml.'],
            ['sku' => 'HMD-004', 'name' => 'Sabun Cuci Piring Sunlight', 'description' => 'Sabun cuci piring cair, 750ml.'],
            ['sku' => 'HMD-005', 'name' => 'Kain Lap Microfiber', 'description' => 'Set 3 kain lap microfiber serbaguna.'],
        ];

        Product::insert($products);
    }
}