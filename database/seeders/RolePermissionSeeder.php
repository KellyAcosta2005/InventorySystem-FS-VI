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
        $manageOperators = Permission::findOrCreate('manage operators', 'web');

        Role::findOrCreate('Administrador', 'web')
            ->syncPermissions([$manageProducts, $registerMovements, $manageOperators]);

        Role::findOrCreate('Operario', 'web')
            ->syncPermissions([$registerMovements]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
