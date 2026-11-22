<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'webassets.tech@gmail.com'],
            [
                'name' => 'Master Admin',
                'phone' => '7006338617',
                'status' => 1,
                'email_verified_at' => now(),
                'password' => Hash::make('Allah@786')
            ]
        );
        $admin->syncRoles(['Super Admin']);
    }
}
