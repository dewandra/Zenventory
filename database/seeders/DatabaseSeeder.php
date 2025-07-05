<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

            $this->call(RolesAndPermissionsSeeder::class);

            $this->call(LocationSeeder::class);

        // (Opsional) Beri peran pada user pertama yang dibuat
        $user = \App\Models\User::first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
