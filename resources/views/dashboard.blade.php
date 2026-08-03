<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <a href="{{ route('warehouses.index') }}" class="block rounded-lg border border-gray-200 bg-white p-6 shadow-sm hover:bg-gray-50">
                    <h3 class="text-lg font-semibold">Warehouses</h3>
                    <p class="mt-2 text-sm text-gray-600">Manage storage locations and inventory sites.</p>
                </a>

                <a href="{{ route('categories.index') }}" class="block rounded-lg border border-gray-200 bg-white p-6 shadow-sm hover:bg-gray-50">
                    <h3 class="text-lg font-semibold">Categories</h3>
                    <p class="mt-2 text-sm text-gray-600">Organize products by their category and prefixes.</p>
                </a>

                <a href="{{ route('item-types.index') }}" class="block rounded-lg border border-gray-200 bg-white p-6 shadow-sm hover:bg-gray-50">
                    <h3 class="text-lg font-semibold">Item Types</h3>
                    <p class="mt-2 text-sm text-gray-600">Track device and asset kinds across the inventory.</p>
                </a>

                <a href="{{ route('products.index') }}" class="block rounded-lg border border-gray-200 bg-white p-6 shadow-sm hover:bg-gray-50">
                    <h3 class="text-lg font-semibold">Products</h3>
                    <p class="mt-2 text-sm text-gray-600">Create and maintain full product records.</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
