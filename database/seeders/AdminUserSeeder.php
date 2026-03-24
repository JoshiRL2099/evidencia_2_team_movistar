<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'ADMIN')->first();

        if (!$adminRole) {
            return;
        }

        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'password_hash' => Hash::make('Admin12345'),
                'full_name' => 'Administrador General',
                'email' => 'admin@boxhalcon.com',
                'is_active' => true,
                'created_at' => now(),
                'role_id' => $adminRole->role_id,
            ]
        );
    }
}