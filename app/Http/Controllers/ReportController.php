<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ItemType;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index()
    {
        $totals = [
            'products' => Product::count(),
            'warehouses' => Warehouse::count(),
            'categories' => Category::count(),
            'item_types' => ItemType::count(),
        ];

        $inventoryByWarehouse = Warehouse::withCount('products')->get();
        $inventoryByCategory = Category::withCount('products')->get();
        $inventoryByItemType = ItemType::withCount('products')->get();

        return view('reports.index', compact('totals', 'inventoryByWarehouse', 'inventoryByCategory', 'inventoryByItemType'));
    }

    public function export()
    {
        $products = Product::with(['warehouse', 'category', 'itemType'])->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="inventory-export.csv"',
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Product Code', 'Name', 'Brand', 'Model', 'Warehouse', 'Category', 'Item Type', 'Status', 'Purchase Date', 'Purchase Price']);

            foreach ($products as $product) {
                fputcsv($file, [
                    $product->product_code,
                    $product->name,
                    $product->brand,
                    $product->model,
                    $product->warehouse?->name,
                    $product->category?->name,
                    $product->itemType?->name,
                    $product->status,
                    $product->purchase_date?->format('Y-m-d'),
                    $product->purchase_price,
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
