<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ItemType;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totals = [
            'products' => Product::count(),
            'warehouses' => Warehouse::count(),
            'categories' => Category::count(),
            'item_types' => ItemType::count(),
        ];

        $itemTypeBreakdown = ItemType::withCount('products')->get();
        $recentProducts = Product::with(['warehouse', 'category', 'itemType'])->latest()->take(5)->get();

        return view('dashboard', compact('totals', 'itemTypeBreakdown', 'recentProducts'));
    }
}
