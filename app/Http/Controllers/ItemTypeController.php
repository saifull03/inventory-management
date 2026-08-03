<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ItemTypeController extends Controller
{
    public function index()
    {
        $itemTypes = ItemType::latest()->get();

        return view('item-types.index', compact('itemTypes'));
    }

    public function create()
    {
        return view('item-types.create');
    }

    public function show(ItemType $itemType)
    {
        return view('item-types.edit', compact('itemType'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:item_types,name'],
            'description' => ['nullable', 'string'],
        ]);

        ItemType::create($validated);

        return redirect()->route('item-types.index')
            ->with('success', 'Item type created successfully.');
    }

    public function edit(ItemType $itemType)
    {
        return view('item-types.edit', compact('itemType'));
    }

    public function update(Request $request, ItemType $itemType)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('item_types', 'name')->ignore($itemType->id)],
            'description' => ['nullable', 'string'],
        ]);

        $itemType->update($validated);

        return redirect()->route('item-types.index')
            ->with('success', 'Item type updated successfully.');
    }

    public function destroy(ItemType $itemType)
    {
        $itemType->delete();

        return redirect()->route('item-types.index')
            ->with('success', 'Item type deleted successfully.');
    }
}
