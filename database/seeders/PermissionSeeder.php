<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create-role',
            'edit-role',
            'delete-role',
            'list-role',
            'create-user',
            'edit-user',
            'delete-user',
            'list-user', 
            'edit-court',
            'update-status',
            'delete-court',
            'create-court',
            'list-court',
            'create-case',
            'edit-case',
            'delete-case',
            'list-case',
            'create-deadcase',
            'edit-deadcase',
            'delete-deadcase',
            'list-deadcase',
            'view-setting',
            'view-report',
            'view-comment',
            'change-password'
         ];
 
          // Looping and Inserting Array's Permissions into Permission Table
         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
          }
    }
}