<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Product
        </h2>
    </x-slot>

    <div class="p-6">
        @if ($errors->any())
            <div class="mb-4 rounded border border-red-200 bg-red-100 p-3 text-red-800">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-4 rounded-lg bg-white p-6 shadow-sm">
            @csrf
            @method('PUT')

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Product Code</label>
                    <input type="text" name="product_code" value="{{ old('product_code', $product->product_code) }}" class="w-full rounded border-gray-300" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full rounded border-gray-300" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="w-full rounded border-gray-300" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Model</label>
                    <input type="text" name="model" value="{{ old('model', $product->model) }}" class="w-full rounded border-gray-300" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Serial number</label>
                    <input type="text" name="serial_number" value="{{ old('serial_number', $product->serial_number) }}" class="w-full rounded border-gray-300">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="w-full rounded border-gray-300">
                        @foreach (['Available', 'Assigned', 'Maintenance', 'Damaged', 'Disposed', 'In Stock', 'Reserved'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $product->status) === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Warehouse</label>
                    <select name="warehouse_id" class="w-full rounded border-gray-300" required>
                        <option value="">Select warehouse</option>
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" @selected(old('warehouse_id', $product->warehouse_id) == $warehouse->id)>{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" class="w-full rounded border-gray-300" required>
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Item Type</label>
                    <select name="item_type_id" class="w-full rounded border-gray-300" required>
                        <option value="">Select item type</option>
                        @foreach ($itemTypes as $itemType)
                            <option value="{{ $itemType->id }}" @selected(old('item_type_id', $product->item_type_id) == $itemType->id)>{{ $itemType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Purchase date</label>
                    <input type="date" name="purchase_date" value="{{ old('purchase_date', $product->purchase_date ? \Illuminate\Support\Carbon::parse($product->purchase_date)->format('Y-m-d') : '') }}" class="w-full rounded border-gray-300">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Purchase price</label>
                    <input type="number" step="0.01" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" class="w-full rounded border-gray-300">
                </div>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" class="w-full rounded border-gray-300">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded bg-green-600 px-4 py-2 text-white">Update Product</button>
                <a href="{{ route('products.index') }}" class="rounded bg-gray-500 px-4 py-2 text-white">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
