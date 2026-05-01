<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderDeliveryAddress;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'createdBy', 'items'])
            ->where('is_deleted', false)
            ->orderByDesc('created_at')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::orderBy('display_name')->get();
        $products = Product::where('active', true)->orderBy('name')->get();

        return view('orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'invoice_number'       => ['required', 'string', 'max:255'],
            'customer_id'          => ['required', 'exists:customers,customer_id'],
            'order_datetime'       => ['required', 'date'],
            'notes'                => ['nullable', 'string'],

            'street'               => ['required', 'string', 'max:255'],
            'ext_number'           => ['required', 'string', 'max:50'],
            'int_number'           => ['nullable', 'string', 'max:50'],
            'neighborhood'         => ['required', 'string', 'max:255'],
            'city'                 => ['required', 'string', 'max:255'],
            'state'                => ['required', 'string', 'max:255'],
            'zip'                  => ['required', 'string', 'max:20'],
            'references'           => ['nullable', 'string', 'max:255'],

            'items'                => ['required', 'array', 'min:1'],
            'items.*.product_id'   => ['required', 'exists:products,product_id'],
            'items.*.quantity'     => ['required', 'integer', 'min:1'], // ✅ entero
            'items.*.unit_price'   => ['nullable', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($data) {
            $order = Order::create([
                'invoice_number'      => $data['invoice_number'],
                'order_datetime'      => $data['order_datetime'],
                'notes'               => $data['notes'] ?? null,
                'status'              => 'ORDERED',
                'is_deleted'          => false,
                'created_at'          => now(),
                'updated_at'          => now(),
                'customer_id'         => $data['customer_id'],
                'created_by_user_id'  => Auth::user()->user_id,
            ]);

            OrderDeliveryAddress::create([
                'street'       => $data['street'],
                'ext_number'   => $data['ext_number'],
                'int_number'   => $data['int_number'] ?? null,
                'neighborhood' => $data['neighborhood'],
                'city'         => $data['city'],
                'state'        => $data['state'],
                'zip'          => $data['zip'],
                'references'   => $data['references'] ?? null,
                'order_id'     => $order->order_id,
            ]);

            foreach ($data['items'] as $item) {
                // ✅ Precio jalado del producto, no del formulario
                $product = Product::find($item['product_id']);
                OrderItem::create([
                    'order_id'   => $order->order_id,
                    'product_id' => $item['product_id'],
                    'quantity'   => (int) $item['quantity'],
                    'unit_price' => $product->price ?? 0,
                ]);
            }
        });

        return redirect()->route('orders.index')
            ->with('success', 'Orden creada correctamente.');
    }

    public function show(string $id)
    {
        $order = Order::with([
            'customer',
            'createdBy',
            'deliveryAddress',
            'items.product',
            'statusHistory.changedBy',
            'photos'
        ])->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function edit(string $id)
    {
        $order = Order::with(['deliveryAddress', 'items.product'])->findOrFail($id);
        $customers = Customer::orderBy('display_name')->get();
        $products = Product::where('active', true)->orderBy('name')->get(); // ✅ AGREGADO

        return view('orders.edit', compact('order', 'customers', 'products')); // ✅ AGREGADO
    }

    public function update(Request $request, string $id)
    {
        $order = Order::with(['deliveryAddress', 'items'])->findOrFail($id);

        $data = $request->validate([
            'invoice_number'       => ['required', 'string', 'max:255'],
            'customer_id'          => ['required', 'exists:customers,customer_id'],
            'order_datetime'       => ['required', 'date'],
            'status'               => ['required', 'in:ORDERED,IN_PROCESS,IN_ROUTE,DELIVERED,DELETED'],
            'notes'                => ['nullable', 'string'],

            'street'               => ['nullable', 'string', 'max:255'],
            'ext_number'           => ['nullable', 'string', 'max:50'],
            'int_number'           => ['nullable', 'string', 'max:50'],
            'neighborhood'         => ['nullable', 'string', 'max:255'],
            'city'                 => ['nullable', 'string', 'max:255'],
            'state'                => ['nullable', 'string', 'max:255'],
            'zip'                  => ['nullable', 'string', 'max:20'],
            'references'           => ['nullable', 'string', 'max:255'],

            'items'                => ['required', 'array', 'min:1'],
            'items.*.product_id'   => ['required', 'exists:products,product_id'],
            'items.*.quantity'     => ['required', 'integer', 'min:1'], // ✅ entero
            'items.*.unit_price'   => ['nullable', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($order, $data) {
            $order->update([
                'invoice_number' => $data['invoice_number'],
                'customer_id'    => $data['customer_id'],
                'order_datetime' => $data['order_datetime'],
                'status'         => $data['status'],
                'notes'          => $data['notes'] ?? null,
                'updated_at'     => now(),
            ]);

            if ($order->deliveryAddress) {
                $order->deliveryAddress->update([
                    'street'       => $data['street'] ?? null,
                    'ext_number'   => $data['ext_number'] ?? null,
                    'int_number'   => $data['int_number'] ?? null,
                    'neighborhood' => $data['neighborhood'] ?? null,
                    'city'         => $data['city'] ?? null,
                    'state'        => $data['state'] ?? null,
                    'zip'          => $data['zip'] ?? null,
                    'references'   => $data['references'] ?? null,
                ]);
            }

            // ✅ Eliminar items anteriores y recrgarlos
            $order->items()->delete();

            foreach ($data['items'] as $item) {
                $product = Product::find($item['product_id']);
                OrderItem::create([
                    'order_id'   => $order->order_id,
                    'product_id' => $item['product_id'],
                    'quantity'   => (int) $item['quantity'],
                    'unit_price' => $product->price ?? 0, // ✅ precio del producto
                ]);
            }
        });

        return redirect()->route('orders.index')
            ->with('success', 'Orden actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status'     => 'DELETED',
            'is_deleted' => true,
            'deleted_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Orden enviada a la papelera.');
    }

    public function trash()
    {
        $orders = Order::with(['customer', 'createdBy', 'items'])
            ->where('is_deleted', true)
            ->orderByDesc('deleted_at')
            ->get();

        return view('orders.trash', compact('orders'));
    }

    public function restore(string $id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status'     => 'ORDERED',
            'is_deleted' => false,
            'deleted_at' => null,
            'updated_at' => now(),
        ]);

        return redirect()->route('orders.trash')
            ->with('success', 'Orden restaurada correctamente.');
    }
}