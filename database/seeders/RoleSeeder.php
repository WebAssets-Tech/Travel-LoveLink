<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        $JDPG = Role::create(['name' => 'JDP(G)']); 
        $JDPD = Role::create(['name' => 'JDP(D)']);
        $DOP = Role::create(['name' => 'DOP']); 
        $SSP = Role::create(['name' => 'SSP']);
        $PP = Role::create(['name' => 'PP']);
 
 

        $DOP->givePermissionTo([
            'list-case' ,
            'view-report',
            'view-comment'
        ]);
        $JDPG->givePermissionTo([
            'list-case' ,
            'view-report',
            'view-comment'
        ]);

        $JDPD->givePermissionTo([
            'list-case' ,
            'view-report',
            'view-comment'
        ]);

        $PP->givePermissionTo([
            'list-case',
            'create-case',
            'edit-case'
        ]);
        $SSP->givePermissionTo([
            'list-case',
            'create-case',
            'edit-case',
            'delete-case',
            'list-deadcase',
            'create-deadcase',
            'edit-deadcase',
            'delete-deadcase',
            'view-report',
            'view-comment'
        ]);
    }
}