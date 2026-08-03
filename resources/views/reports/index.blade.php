<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inventory Reports
            </h2>
            <a href="{{ route('reports.export') }}" class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                Export CSV
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Products</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totals['products'] }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Warehouses</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totals['warehouses'] }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Categories</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totals['categories'] }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Item Types</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totals['item_types'] }}</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900">By Warehouse</h3>
                    <ul class="mt-4 space-y-2 text-sm text-gray-600">
                        @foreach ($inventoryByWarehouse as $warehouse)
                            <li class="flex items-center justify-between">
                                <span>{{ $warehouse->name }}</span>
                                <span class="font-semibold text-gray-900">{{ $warehouse->products_count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900">By Category</h3>
                    <ul class="mt-4 space-y-2 text-sm text-gray-600">
                        @foreach ($inventoryByCategory as $category)
                            <li class="flex items-center justify-between">
                                <span>{{ $category->name }}</span>
                                <span class="font-semibold text-gray-900">{{ $category->products_count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900">By Item Type</h3>
                    <ul class="mt-4 space-y-2 text-sm text-gray-600">
                        @foreach ($inventoryByItemType as $itemType)
                            <li class="flex items-center justify-between">
                                <span>{{ $itemType->name }}</span>
                                <span class="font-semibold text-gray-900">{{ $itemType->products_count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
