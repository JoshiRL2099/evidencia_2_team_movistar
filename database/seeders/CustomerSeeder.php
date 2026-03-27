<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\FiscalData;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'customer_number' => 'CL-45892',
                'display_name' => 'Construcciones Modernas SA',
                'address' => [
                    'street' => 'Av. Principal',
                    'ext_number' => '123',
                    'int_number' => null,
                    'neighborhood' => 'Centro',
                    'city' => 'Toluca',
                    'state' => 'Estado de México',
                    'zip' => '50000',
                    'references' => 'Frente a la plaza',
                ],
                'fiscal' => [
                    'rfc' => 'CMA123456789',
                    'legal_name' => 'Construcciones Modernas SA de CV',
                    'tax_regime' => 'General de Ley Personas Morales',
                    'cfdi_use' => 'G03',
                    'email_for_invoice' => 'facturacion@cm.com',
                ],
            ],
            [
                'customer_number' => 'CL-10001',
                'display_name' => 'Materiales del Norte',
                'address' => [
                    'street' => 'Calle Industrial',
                    'ext_number' => '45',
                    'int_number' => null,
                    'neighborhood' => 'Zona Industrial',
                    'city' => 'Monterrey',
                    'state' => 'Nuevo León',
                    'zip' => '64000',
                    'references' => null,
                ],
                'fiscal' => null,
            ],
            [
                'customer_number' => 'CL-20002',
                'display_name' => 'Ferretería López',
                'address' => [
                    'street' => 'Av. Hidalgo',
                    'ext_number' => '890',
                    'int_number' => '2',
                    'neighborhood' => 'Centro',
                    'city' => 'Guadalajara',
                    'state' => 'Jalisco',
                    'zip' => '44100',
                    'references' => 'A un lado del banco',
                ],
                'fiscal' => [
                    'rfc' => 'FLO987654321',
                    'legal_name' => 'Ferretería López SA',
                    'tax_regime' => 'Régimen Simplificado',
                    'cfdi_use' => 'G01',
                    'email_for_invoice' => 'facturas@lopez.com',
                ],
            ],
        ];

        foreach ($customers as $c) {
            $customer = Customer::firstOrCreate(
                ['customer_number' => $c['customer_number']],
                [
                    'display_name' => $c['display_name'],
                    'created_at' => now(),
                ]
            );

            // Dirección (1:1)
            CustomerAddress::updateOrCreate(
                ['customer_id' => $customer->customer_id],
                array_merge($c['address'], [
                    'customer_id' => $customer->customer_id,
                ])
            );

            // Datos fiscales (opcional)
            if ($c['fiscal']) {
                FiscalData::updateOrCreate(
                    ['customer_id' => $customer->customer_id],
                    array_merge($c['fiscal'], [
                        'customer_id' => $customer->customer_id,
                    ])
                );
            }
        }
    }
}