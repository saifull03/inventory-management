<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemTypeRequest;
use App\Http\Requests\UpdateItemTypeRequest;
use App\Models\ItemType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $itemTypes = ItemType::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('item-types.index', compact('itemTypes'));
    }

    public function create()
    {
        return view('item-types.create');
    }

    public function store(StoreItemTypeRequest $request)
    {
        ItemType::create($request->validated());

        return redirect()->route('item-types.index')->with('success', 'Item type created successfully.');
    }

    public function show(ItemType $itemType)
    {
        return view('item-types.edit', compact('itemType'));
    }

    public function edit(ItemType $itemType)
    {
        return view('item-types.edit', compact('itemType'));
    }

    public function update(UpdateItemTypeRequest $request, ItemType $itemType)
    {
        $itemType->update($request->validated());

        return redirect()->route('item-types.index')->with('success', 'Item type updated successfully.');
    }

    public function destroy(ItemType $itemType)
    {
        $itemType->delete();

        return redirect()->route('item-types.index')->with('success', 'Item type deleted successfully.');
    }
}
