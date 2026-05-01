<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicOrderController extends Controller
{
    public function lookup(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'invoice_number' => ['required', 'string'],
            'customer_number' => ['required', 'string'],
        ], [
            'invoice_number.required' => 'El número de pedido es obligatorio.',
            'customer_number.required' => 'El número de cliente es obligatorio.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $invoiceNumber = $request->input('invoice_number');
        $customerNumber = $request->input('customer_number');

        $order = Order::query()
            ->with('customer')
            ->where('invoice_number', $invoiceNumber)
            ->where('is_deleted', false)
            ->where('status', '!=', 'DELETED')
            ->whereHas('customer', function ($query) use ($customerNumber) {
                $query->where('customer_number', $customerNumber);
            })
            ->first();

        if (!$order) {
            return response()->json([
                'message' => 'No se encontró un pedido con ese número para ese cliente.',
            ], 404);
        }

        return response()->json([
            'message' => 'Pedido encontrado.',
            'data' => [
                'order_id' => $order->order_id,
                'invoice_number' => $order->invoice_number,
                'order_datetime' => optional($order->order_datetime)->format('Y-m-d H:i:s'),
                'status' => $order->status,
                'notes' => $order->notes,
                'customer' => [
                    'customer_id' => $order->customer?->customer_id,
                    'customer_number' => $order->customer?->customer_number,
                    'display_name' => $order->customer?->display_name,
                ],
            ],
        ]);
    }
}