<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'menu-user',
            'permission-view',
            'permission-delete',
            'permission-store',
            'user-view',
            'user-delete',
            'user-create',
            // 
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'product-list',
            'product-create',
            'product-edit',
            'product-delete'
         ];
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
