<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\FiscalData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with(['address', 'fiscalData'])
            ->orderBy('display_name')
            ->get();

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_number' => ['required', 'string', 'max:255', 'unique:customers,customer_number'],
            'display_name' => ['required', 'string', 'max:255'],

            'street' => ['required', 'string', 'max:255'],
            'ext_number' => ['required', 'string', 'max:50'],
            'int_number' => ['nullable', 'string', 'max:50'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'max:20'],
            'references' => ['nullable', 'string'],

            'rfc' => ['nullable', 'string', 'max:50'],
            'legal_name' => ['nullable', 'string', 'max:255'],
            'tax_regime' => ['nullable', 'string', 'max:255'],
            'cfdi_use' => ['nullable', 'string', 'max:255'],
            'email_for_invoice' => ['nullable', 'email', 'max:255'],
        ]);

        DB::transaction(function () use ($data) {
            $customer = Customer::create([
                'customer_number' => $data['customer_number'],
                'display_name' => $data['display_name'],
                'created_at' => now(),
            ]);

            CustomerAddress::create([
                'street' => $data['street'],
                'ext_number' => $data['ext_number'],
                'int_number' => $data['int_number'] ?? null,
                'neighborhood' => $data['neighborhood'],
                'city' => $data['city'],
                'state' => $data['state'],
                'zip' => $data['zip'],
                'references' => $data['references'] ?? null,
                'customer_id' => $customer->customer_id,
            ]);

            if (!empty($data['rfc'])) {
                FiscalData::create([
                    'rfc' => $data['rfc'],
                    'legal_name' => $data['legal_name'] ?? '',
                    'tax_regime' => $data['tax_regime'] ?? '',
                    'cfdi_use' => $data['cfdi_use'] ?? '',
                    'email_for_invoice' => $data['email_for_invoice'] ?? '',
                    'customer_id' => $customer->customer_id,
                ]);
            }
        });

        return redirect()->route('customers.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    public function show(string $id)
    {
        $customer = Customer::with(['address', 'fiscalData', 'orders'])->findOrFail($id);

        return view('customers.show', compact('customer'));
    }

    public function edit(string $id)
    {
        $customer = Customer::with(['address', 'fiscalData'])->findOrFail($id);

        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, string $id)
    {
        $customer = Customer::with(['address', 'fiscalData'])->findOrFail($id);

        $data = $request->validate([
            'customer_number' => ['required', 'string', 'max:255', 'unique:customers,customer_number,' . $id . ',customer_id'],
            'display_name' => ['required', 'string', 'max:255'],

            'street' => ['required', 'string', 'max:255'],
            'ext_number' => ['required', 'string', 'max:50'],
            'int_number' => ['nullable', 'string', 'max:50'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'max:20'],
            'references' => ['nullable', 'string'],

            'rfc' => ['nullable', 'string', 'max:50'],
            'legal_name' => ['nullable', 'string', 'max:255'],
            'tax_regime' => ['nullable', 'string', 'max:255'],
            'cfdi_use' => ['nullable', 'string', 'max:255'],
            'email_for_invoice' => ['nullable', 'email', 'max:255'],
        ]);

        DB::transaction(function () use ($customer, $data) {
            $customer->update([
                'customer_number' => $data['customer_number'],
                'display_name' => $data['display_name'],
            ]);

            if ($customer->address) {
                $customer->address->update([
                    'street' => $data['street'],
                    'ext_number' => $data['ext_number'],
                    'int_number' => $data['int_number'] ?? null,
                    'neighborhood' => $data['neighborhood'],
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'zip' => $data['zip'],
                    'references' => $data['references'] ?? null,
                ]);
            }

            if (!empty($data['rfc'])) {
                if ($customer->fiscalData) {
                    $customer->fiscalData->update([
                        'rfc' => $data['rfc'],
                        'legal_name' => $data['legal_name'] ?? '',
                        'tax_regime' => $data['tax_regime'] ?? '',
                        'cfdi_use' => $data['cfdi_use'] ?? '',
                        'email_for_invoice' => $data['email_for_invoice'] ?? '',
                    ]);
                } else {
                    FiscalData::create([
                        'rfc' => $data['rfc'],
                        'legal_name' => $data['legal_name'] ?? '',
                        'tax_regime' => $data['tax_regime'] ?? '',
                        'cfdi_use' => $data['cfdi_use'] ?? '',
                        'email_for_invoice' => $data['email_for_invoice'] ?? '',
                        'customer_id' => $customer->customer_id,
                    ]);
                }
            }
        });

        return redirect()->route('customers.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}