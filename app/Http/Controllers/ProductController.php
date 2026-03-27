<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku'],
            'name' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:100'],
            'stock_quantity' => ['required', 'numeric', 'min:0'],
            'active' => ['nullable', 'boolean'],
        ]);

        Product::create([
            'sku' => $data['sku'],
            'name' => $data['name'],
            'unit' => $data['unit'],
            'stock_quantity' => $data['stock_quantity'],
            'active' => $request->boolean('active'),
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku,' . $id . ',product_id'],
            'name' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:100'],
            'stock_quantity' => ['required', 'numeric', 'min:0'],
            'active' => ['nullable', 'boolean'],
        ]);

        $product->update([
            'sku' => $data['sku'],
            'name' => $data['name'],
            'unit' => $data['unit'],
            'stock_quantity' => $data['stock_quantity'],
            'active' => $request->boolean('active'),
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}