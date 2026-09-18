<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $manageProducts = Permission::findOrCreate('manage products', 'web');
        $registerMovements = Permission::findOrCreate('register movements', 'web');

        Role::findOrCreate('administrador', 'web')
            ->syncPermissions([$manageProducts, $registerMovements]);

        Role::findOrCreate('operario', 'web')
            ->syncPermissions([$registerMovements]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
