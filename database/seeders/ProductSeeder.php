<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'sku' => 'CEM-001',
                'name' => 'Cemento',
                'unit' => 'bolsas',
                'stock_quantity' => 120,
                'minimum_stock' => 20,
                'active' => true,
            ],
            [
                'sku' => 'VAR-002',
                'name' => 'Varilla 1/2"',
                'unit' => 'piezas',
                'stock_quantity' => 80,
                'minimum_stock' => 15,
                'active' => true,
            ],
            [
                'sku' => 'CAL-003',
                'name' => 'Cal',
                'unit' => 'sacos',
                'stock_quantity' => 0,
                'minimum_stock' => 10,
                'active' => true,
            ],
            [
                'sku' => 'ARE-004',
                'name' => 'Arena',
                'unit' => 'm3',
                'stock_quantity' => 12,
                'minimum_stock' => 5,
                'active' => true,
            ],
            [
                'sku' => 'GRA-005',
                'name' => 'Grava',
                'unit' => 'm3',
                'stock_quantity' => 0,
                'minimum_stock' => 5,
                'active' => true,
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(
                ['sku' => $p['sku']],
                $p
            );
        }
    }
}