<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'manage products']);
        Permission::create(['name' => 'manage locations']);
        Permission::create(['name' => 'view reports']);
        Permission::create(['name' => 'perform inbound']);
        Permission::create(['name' => 'perform outbound']);

        // create roles and assign created permissions

        $role = Role::create(['name' => 'staff']);
        $role->givePermissionTo(['perform inbound', 'perform outbound']);

        $role = Role::create(['name' => 'manager']);
        $role->givePermissionTo(['manage products', 'manage locations', 'view reports']);

        // Admin mendapatkan semua izin
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
    }
}
