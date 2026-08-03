<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ItemType;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['warehouse', 'category', 'itemType', 'creator'])
            ->latest()
            ->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create', [
            'warehouses' => Warehouse::all(),
            'categories' => Category::all(),
            'itemTypes' => ItemType::all(),
        ]);
    }

    public function show(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
            'warehouses' => Warehouse::all(),
            'categories' => Category::all(),
            'itemTypes' => ItemType::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_code' => ['required', 'string', 'max:100', 'unique:products,product_code'],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'warehouse_id' => ['required', 'exists:warehouses,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'item_type_id' => ['required', 'exists:item_types,id'],
            'status' => ['required', Rule::in(['Available', 'Assigned', 'Maintenance', 'Damaged', 'Disposed'])],
            'purchase_date' => ['nullable', 'date'],
            'purchase_price' => ['nullable', 'numeric'],
        ]);

        $validated['created_by'] = auth()->id();

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
            'warehouses' => Warehouse::all(),
            'categories' => Category::all(),
            'itemTypes' => ItemType::all(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_code' => ['required', 'string', 'max:100', Rule::unique('products', 'product_code')->ignore($product->id)],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'warehouse_id' => ['required', 'exists:warehouses,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'item_type_id' => ['required', 'exists:item_types,id'],
            'status' => ['required', Rule::in(['Available', 'Assigned', 'Maintenance', 'Damaged', 'Disposed'])],
            'purchase_date' => ['nullable', 'date'],
            'purchase_price' => ['nullable', 'numeric'],
        ]);

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
