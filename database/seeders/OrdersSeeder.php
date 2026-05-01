<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrdersSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::where('username', 'admin')->first();

        if (!$adminUser) {
            return;
        }

        $customerOne = Customer::where('customer_number', 'CL-10001')->first();
        $customerTwo = Customer::where('customer_number', 'CL-20002')->first();

        if (!$customerOne || !$customerTwo) {
            return;
        }

        Order::firstOrCreate(
            ['invoice_number' => 'FAC-1001'],
            [
                'order_id' => (string) Str::uuid(),
                'order_datetime' => now()->subDays(2),
                'notes' => 'Pedido de prueba para Materiales del Norte',
                'status' => 'ORDERED',
                'is_deleted' => false,
                'deleted_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'customer_id' => $customerOne->customer_id,
                'created_by_user_id' => $adminUser->user_id,
            ]
        );

        Order::firstOrCreate(
            ['invoice_number' => 'FAC-1002'],
            [
                'order_id' => (string) Str::uuid(),
                'order_datetime' => now()->subDay(),
                'notes' => 'Pedido en proceso de preparación',
                'status' => 'IN_PROCESS',
                'is_deleted' => false,
                'deleted_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'customer_id' => $customerOne->customer_id,
                'created_by_user_id' => $adminUser->user_id,
            ]
        );

        Order::firstOrCreate(
            ['invoice_number' => 'FAC-2001'],
            [
                'order_id' => (string) Str::uuid(),
                'order_datetime' => now()->subHours(10),
                'notes' => 'Pedido asignado para entrega',
                'status' => 'IN_ROUTE',
                'is_deleted' => false,
                'deleted_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'customer_id' => $customerTwo->customer_id,
                'created_by_user_id' => $adminUser->user_id,
            ]
        );

        Order::firstOrCreate(
            ['invoice_number' => 'FAC-2002'],
            [
                'order_id' => (string) Str::uuid(),
                'order_datetime' => now()->subDays(5),
                'notes' => 'Pedido ya entregado',
                'status' => 'DELIVERED',
                'is_deleted' => false,
                'deleted_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'customer_id' => $customerTwo->customer_id,
                'created_by_user_id' => $adminUser->user_id,
            ]
        );
    }
}