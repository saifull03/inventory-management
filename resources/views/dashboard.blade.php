<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Welcome back</p>
                <h3 class="mt-1 text-2xl font-semibold text-gray-900">Inventory overview</h3>
                <p class="mt-2 text-sm text-gray-600">Track your warehouses, categories, item types, and products in one place.</p>
            </div>

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

            <div class="grid gap-6 lg:grid-cols-[1.4fr_0.8fr]">
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Recent products</h3>
                        <a href="{{ route('products.index') }}" class="text-sm font-medium text-blue-600">View all</a>
                    </div>

                    <div class="mt-4 space-y-3">
                        @forelse ($recentProducts as $product)
                            <div class="flex items-center justify-between rounded border border-gray-100 px-3 py-2">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $product->product_code }} · {{ $product->warehouse?->name ?? 'No warehouse' }}</p>
                                </div>
                                <span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700">{{ $product->status }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No products have been added yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900">Quick links</h3>
                    <div class="mt-4 space-y-2">
                        <a href="{{ route('warehouses.index') }}" class="block rounded border border-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">Manage warehouses</a>
                        <a href="{{ route('categories.index') }}" class="block rounded border border-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">Manage categories</a>
                        <a href="{{ route('item-types.index') }}" class="block rounded border border-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">Manage item types</a>
                        <a href="{{ route('reports.index') }}" class="block rounded border border-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">Open reports</a>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">Inventory by item type</h3>
                <div class="mt-4 grid gap-3 md:grid-cols-2">
                    @foreach ($itemTypeBreakdown as $itemType)
                        <div class="rounded border border-gray-100 px-3 py-2">
                            <p class="font-medium text-gray-900">{{ $itemType->name }}</p>
                            <p class="text-sm text-gray-500">{{ $itemType->products_count }} products</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
