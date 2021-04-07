<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Ojan', 
            'email' => 'admin@admin.com',
            'password' => bcrypt('masfauzan')
        ]);
        $role = Role::create(['name' => 'Admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);

        $guest =  User::create([
            'name' => 'Guest', 
            'email' => 'guets@admin.com',
            'password' => bcrypt('masfauzan')
        ]);
        $role_guest = Role::create(['name' => 'Guest']);
        $permissions_guest = Permission::create(['name' => 'view-only']);
        $role_guest->syncPermissions($permissions_guest);
        $guest->assignRole('guest');
    }
}
