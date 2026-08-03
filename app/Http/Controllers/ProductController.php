<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\ItemType;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $products = Product::query()
            ->with(['warehouse', 'category', 'itemType', 'creator'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('product_code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('brand', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%")
                        ->orWhereHas('warehouse', function ($warehouseQuery) use ($search) {
                            $warehouseQuery->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('category', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('itemType', function ($itemTypeQuery) use ($search) {
                            $itemTypeQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('warehouse_id'), fn ($query) => $query->where('warehouse_id', $request->warehouse_id))
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('item_type_id'), fn ($query) => $query->where('item_type_id', $request->item_type_id))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('sort_by'), function ($query) use ($request) {
                $direction = $request->get('sort_dir', 'asc');
                $query->orderBy($request->get('sort_by'), $direction);
            }, function ($query) {
                $query->latest('created_at');
            })
            ->paginate(15)
            ->withQueryString();

        $warehouses = Warehouse::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $itemTypes = ItemType::orderBy('name')->get();

        return view('products.index', compact('products', 'warehouses', 'categories', 'itemTypes'));
    }

    public function create()
    {
        return view('products.create', [
            'warehouses' => Warehouse::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
            'itemTypes' => ItemType::orderBy('name')->get(),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();
        $validated['product_code'] = $this->generateProductCode($validated['category_id']);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
            'warehouses' => Warehouse::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
            'itemTypes' => ItemType::orderBy('name')->get(),
        ]);
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
            'warehouses' => Warehouse::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
            'itemTypes' => ItemType::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    protected function generateProductCode(int $categoryId): string
    {
        $category = Category::findOrFail($categoryId);
        $prefix = $category->prefix;

        $latestProduct = Product::where('category_id', $categoryId)
            ->latest('id')
            ->value('product_code');

        $nextNumber = 1;
        if ($latestProduct && Str::startsWith($latestProduct, $prefix)) {
            $lastNumber = (int) Str::substr($latestProduct, strlen($prefix));
            $nextNumber = $lastNumber + 1;
        }

        return $prefix . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
