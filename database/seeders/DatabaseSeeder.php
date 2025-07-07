<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Matikan pengecekan foreign key & hapus semua data dengan urutan yang benar
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\ReturnItem::truncate();
        \App\Models\ReturnModel::truncate();
        \App\Models\PicklistItem::truncate();
        \App\Models\Picklist::truncate();
        \App\Models\OrderDetail::truncate();
        \App\Models\Order::truncate();
        \App\Models\InventoryMovement::truncate();
        \App\Models\CycleCountItem::truncate();
        \App\Models\CycleCount::truncate();
        \App\Models\InventoryBatch::truncate();
        \App\Models\Product::truncate();
        \App\Models\Location::truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        Permission::truncate();
        Role::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Buat user Admin utama
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@zenventory.com',
        ]);

        // 3. Panggil seeder untuk peran & hak akses
        $this->call(RolesAndPermissionsSeeder::class);

        // 4. Beri peran 'admin' pada user yang baru dibuat
        $adminUser->assignRole('admin');

        // 5. Panggil seeder data utama
        $this->call([
            LocationSeeder::class,
            ProductSeeder::class,
            InventorySeeder::class,
            OrderSeeder::class,
        ]);
    }
}