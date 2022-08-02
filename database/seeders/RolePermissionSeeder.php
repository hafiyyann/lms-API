<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
       // Create Admin Role
       $admin_role = Role::create([
         'name'        => 'admin',
       ]);

       // Create Chapter Permission
       Permission::create(['name' => 'get-chapters']);
       Permission::create(['name' => 'get-chapter']);
       Permission::create(['name' => 'store-chapter']);
       Permission::create(['name' => 'delete-chapter']);

       // Create Course Permission
       Permission::create(['name' => 'get-courses']);
       Permission::create(['name' => 'get-course']);
       Permission::create(['name' => 'store-course']);
       Permission::create(['name' => 'delete-course']);

       // Assign Permission to Admin
       $admin_role->givePermissionTo([
         'get-chapters',
         'get-chapter',
         'store-chapter',
         'delete-chapter',
         'get-courses',
         'get-course',
         'store-course',
         'delete-course'
       ]);
     }
}
