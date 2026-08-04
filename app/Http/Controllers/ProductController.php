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
            ->with(['warehouse', 'category', 'itemType', 'creator', 'employee'])
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
                        })
                        ->orWhereHas('employee', function ($employeeQuery) use ($search) {
                            $employeeQuery->where('name', 'like', "%{$search}%")
                                         ->orWhere('employee_id', 'like', "%{$search}%");
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
        $employees = \App\Models\Employee::orderBy('name')->get();

        return view('products.index', compact('products', 'warehouses', 'categories', 'itemTypes', 'employees'));
    }

    public function create()
    {
        return view('products.create', [
            'warehouses' => Warehouse::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
            'itemTypes' => ItemType::orderBy('name')->get(),
            'employees' => \App\Models\Employee::orderBy('name')->get(),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();
        
        $categoryId = $validated['category_id'] ?? null;
        $category = Category::find($categoryId);
        $isLicense = $category && (
            str_contains(strtolower($category->name), 'licence') || 
            str_contains(strtolower($category->name), 'license')
        );

        if ($isLicense) {
            $validated['status'] = $validated['status'] ?? 'Available';
        }

        $validated['product_code'] = $this->generateProductCode(
            isset($validated['item_type_id']) ? (int) $validated['item_type_id'] : null,
            (int) $categoryId
        );

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', [
            'product' => $product,
            'employees' => \App\Models\Employee::orderBy('name')->get(),
        ]);
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
            'warehouses' => Warehouse::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
            'itemTypes' => ItemType::orderBy('name')->get(),
            'employees' => \App\Models\Employee::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $categoryId = $validated['category_id'] ?? null;
        $category = Category::find($categoryId);
        $isLicense = $category && (
            str_contains(strtolower($category->name), 'licence') || 
            str_contains(strtolower($category->name), 'license')
        );

        if ($isLicense) {
            $validated['status'] = $validated['status'] ?? 'Available';
            // Explicitly set null to clear these fields if updating to a license
            $validated['brand'] = $validated['brand'] ?? null;
            $validated['model'] = $validated['model'] ?? null;
            $validated['warehouse_id'] = $validated['warehouse_id'] ?? null;
            $validated['item_type_id'] = $validated['item_type_id'] ?? null;
        }

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->employee_id) {
            return redirect()->route('products.index')->with('error', 'Cannot delete product because it is currently assigned to an employee.');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function getNextCode(Request $request)
    {
        $itemTypeId = $request->get('item_type_id');
        $categoryId = $request->get('category_id');
        if (!$itemTypeId && !$categoryId) {
            return response()->json(['code' => '']);
        }

        $code = $this->generateProductCode(
            $itemTypeId ? (int) $itemTypeId : null,
            (int) $categoryId
        );
        return response()->json(['code' => $code]);
    }

    protected function generateProductCode(?int $itemTypeId, int $categoryId): string
    {
        if ($itemTypeId) {
            $itemType = ItemType::findOrFail($itemTypeId);
            $prefix = $itemType->prefix;
            $queryField = 'item_type_id';
            $queryVal = $itemTypeId;
        } else {
            $category = Category::findOrFail($categoryId);
            $prefix = $category->prefix ?: 'LIC';
            $queryField = 'category_id';
            $queryVal = $categoryId;
        }

        $latestProduct = Product::where($queryField, $queryVal)
            ->latest('id')
            ->value('product_code');

        $nextNumber = 1;
        if ($latestProduct && Str::startsWith($latestProduct, $prefix)) {
            $lastNumber = (int) Str::substr($latestProduct, strlen($prefix));
            $nextNumber = $lastNumber + 1;
        }

        return $prefix . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function assignEmployee(Request $request, Product $product)
    {
        $request->validate([
            'employee_id' => ['nullable', 'exists:employees,id'],
        ]);

        $product->update([
            'employee_id' => $request->get('employee_id')
        ]);

        return redirect()->route('products.index')->with('success', 'Employee assigned to product successfully.');
    }
}
