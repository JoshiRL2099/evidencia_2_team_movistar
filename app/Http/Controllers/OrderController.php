<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'createdBy'])
            ->orderByDesc('created_at')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::orderBy('display_name')->get();

        return view('orders.create', compact('customers'));
    }
    
    public function store(Request $request)
    {
     $data = $request->validate([
        'invoice_number' => ['required', 'string', 'max:255'],
        'customer_number' => ['nullable', 'string'],
        'date_time' => ['required', 'date'],
        'name' => ['required', 'string'],
        'phone' => ['nullable', 'string'],
        'rfc' => ['nullable', 'string'],
        'address' => ['required', 'string'],
        'notes' => ['nullable', 'string'],

        'items' => ['nullable', 'array'],
        'items.*.product_id' => ['required_with:items', 'exists:products,id'],
        'items.*.quantity' => ['required_with:items', 'numeric'],
        'items.*.unit_price' => ['nullable', 'numeric'],
    ]);

    $order = Order::create([
        'invoice_number' => $data['invoice_number'],
        'customer_number' => $data['customer_number'] ?? null,
        'name' => $data['name'],
        'phone' => $data['phone'] ?? null,
        'rfc' => $data['rfc'] ?? null,
        'address' => $data['address'],
        'notes' => $data['notes'] ?? null,
        'state' => 'Requested',
        'date_time' => $data['date_time'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    OrderDeliveryAddress::create([
        'order_address_id' => Str::uuid(),
        'order_id' => $order->id,
        'street' => $data['address'], // usamos address aquí
        'ext_number' => 'N/A',
        'neighborhood' => 'N/A',
        'city' => 'N/A',
        'state' => 'N/A',
        'zip' => '00000',
    ]);

    if (!empty($data['items'])) {
        foreach ($data['items'] as $itemData) {
            OrderItem::create([
                'order_item_id' => Str::uuid(),
                'order_id' => $order->id,
                'product_id' => $itemData['product_id'],
                'quantity' => $itemData['quantity'],
                'unit_price' => $itemData['unit_price'] ?? 0,
            ]);
        }
    }

    return redirect()->route('orders.show', $order->id)
        ->with('success', 'Pedido creado correctamente.');
}

    public function show(string $id)
    {
        $order = Order::with([
            'customer',
            'createdBy',
            'deliveryAddress',
            'items.product',
            'photos',
            'statusHistory.changedBy',
        ])->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function edit(string $id)
    {
        $order = Order::findOrFail($id);
        $customers = Customer::orderBy('display_name')->get();

        return view('orders.edit', compact('order', 'customers'));
    }

    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $data = $request->validate([
            'invoice_number' => ['required', 'string', 'max:255'],
            'order_datetime' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'customer_id' => ['required', 'exists:customers,customer_id'],
            'status' => ['required', 'in:ORDERED,IN_PROCESS,IN_ROUTE,DELIVERED,DELETED'],
        ]);

        $order->update([
            'invoice_number' => $data['invoice_number'],
            'order_datetime' => $data['order_datetime'],
            'notes' => $data['notes'] ?? null,
            'customer_id' => $data['customer_id'],
            'status' => $data['status'],
            'updated_at' => now(),
        ]);

        return redirect()->route('orders.show', $order->order_id)
            ->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status' => 'DELETED',
            'is_deleted' => true,
            'deleted_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Pedido eliminado lógicamente.');
    }
}