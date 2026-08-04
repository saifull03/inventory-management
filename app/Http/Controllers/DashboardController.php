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
        // 1. Assets (hardware: all products except licenses, accessories, consumables, components)
        $assetsCount = Product::where(function ($query) {
            $query->whereNull('category_id')
                ->orWhereHas('category', function ($q) {
                    $q->where('name', 'not like', '%licen%')
                      ->where('name', 'not like', '%accessor%')
                      ->where('name', 'not like', '%consum%')
                      ->where('name', 'not like', '%component%');
                });
        })->count();

        // 2. Licenses
        $licensesCount = Product::whereHas('category', function ($q) {
            $q->where('name', 'like', '%licen%');
        })->count();

        // 3. Accessories
        $accessoriesCount = Product::whereHas('category', function ($q) {
            $q->where('name', 'like', '%accessor%');
        })->count();

        // 4. Consumables
        $consumablesCount = Product::whereHas('category', function ($q) {
            $q->where('name', 'like', '%consum%');
        })->count();

        // 5. Components
        $componentsCount = Product::whereHas('category', function ($q) {
            $q->where('name', 'like', '%component%');
        })->count();

        // 6. People (Employees)
        $peopleCount = \App\Models\Employee::count();

        // Status breakdown for the chart
        $statusBreakdown = Product::select('status', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
            ->groupBy('status')
            ->orderBy('count', 'desc')
            ->get();

        // Recent activity: last 10 products created/updated
        $recentActivity = Product::with(['employee', 'creator', 'category'])
            ->latest('updated_at')
            ->take(10)
            ->get();

        $totals = [
            'assets' => $assetsCount,
            'licenses' => $licensesCount,
            'accessories' => $accessoriesCount,
            'consumables' => $consumablesCount,
            'components' => $componentsCount,
            'people' => $peopleCount,
        ];

        return view('dashboard', compact('totals', 'statusBreakdown', 'recentActivity'));
    }
}
