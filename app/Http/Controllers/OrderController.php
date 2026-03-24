<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'order_datetime' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'customer_id' => ['required', 'exists:customers,customer_id'],
        ]);

        $order = Order::create([
            'invoice_number' => $data['invoice_number'],
            'order_datetime' => $data['order_datetime'],
            'notes' => $data['notes'] ?? null,
            'status' => 'ORDERED',
            'is_deleted' => false,
            'created_at' => now(),
            'updated_at' => now(),
            'customer_id' => $data['customer_id'],
            'created_by_user_id' => Auth::id(),
        ]);

        return redirect()->route('orders.show', $order->order_id)
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