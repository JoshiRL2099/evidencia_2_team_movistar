<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'username' => 'usuario1',
                'name' => 'Usuario Compras',
                'email' => 'usuario1@empresa.com',
                'role' => 'PURCHASING',
            ],
            [
                'username' => 'ventas1',
                'name' => 'Usuario Ventas',
                'email' => 'ventas@empresa.com',
                'role' => 'SALES',
            ],
            [
                'username' => 'almacen1',
                'name' => 'Usuario Almacén',
                'email' => 'almacen@empresa.com',
                'role' => 'WAREHOUSE',
            ],
            [
                'username' => 'ruta1',
                'name' => 'Usuario Ruta',
                'email' => 'ruta@empresa.com',
                'role' => 'ROUTE',
            ],
        ];

        foreach ($users as $u) {
            $role = Role::where('name', $u['role'])->first();

            if (!$role) {
                continue;
            }

            User::firstOrCreate(
                ['username' => $u['username']],
                [
                    'password_hash' => Hash::make('User12345'),
                    'full_name' => $u['name'],
                    'email' => $u['email'],
                    'is_active' => true,
                    'created_at' => now(),
                    'role_id' => $role->role_id,
                ]
            );
        }
    }
}