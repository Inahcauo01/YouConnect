<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'add post']);
        Permission::create(['name' => 'edit All post']);
        Permission::create(['name' => 'edit My post']);
        Permission::create(['name' => 'delete All post']);
        Permission::create(['name' => 'delete My post']);

        Permission::create(['name' => 'add like']);
        Permission::create(['name' => 'view like']);
        Permission::create(['name' => 'edit like']);
        Permission::create(['name' => 'delete like']);

        Permission::create(['name' => 'add follow']);
        Permission::create(['name' => 'view follow']);
        Permission::create(['name' => 'edit follow']);
        Permission::create(['name' => 'delete follow']);

        Permission::create(['name' => 'add comment']);
        Permission::create(['name' => 'view comment']);
        Permission::create(['name' => 'edit comment']);
        Permission::create(['name' => 'delete comment']);

        // Define roles available
        $admin = 'admin';
        $user = 'user';

        Role::create(['name' => $admin])->givePermissionTo(Permission::all());

        Role::create(['name' => $user])->givePermissionTo([
            'add post',
            'edit My post',
            'delete My post',
            'add comment',
            'edit comment',
            'delete comment',
        ]);
    }
}
