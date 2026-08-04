<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Products
            </h2>
            <a href="{{ route('products.create') }}" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">
                Add Product
            </a>
        </div>
    </x-slot>

    <div class="p-6">
        @if (session('success'))
            <div class="mb-4 rounded border border-green-200 bg-green-100 p-3 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded border border-red-200 bg-red-100 p-3 text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <!-- Search & Filter Controls -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <form method="GET" action="{{ route('products.index') }}" class="flex w-full max-w-sm gap-2">
                @if(request('category_id'))
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                @endif
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full rounded border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                <button type="submit" class="rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300">
                    Search
                </button>
            </form>
        </div>

        <!-- Categories Filter Tabs/Pills -->
        <div class="mb-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Category Filter</h3>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('products.index', request()->except('category_id')) }}" 
                   class="rounded-full px-4 py-1.5 text-xs font-medium transition {{ !request()->filled('category_id') ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    All Categories
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('products.index', array_merge(request()->except('page'), ['category_id' => $cat->id])) }}" 
                       class="rounded-full px-4 py-1.5 text-xs font-medium transition {{ request('category_id') == $cat->id ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Code</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Product Name</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Category</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Warehouse</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Assigned Employee</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-4 py-3 font-mono text-sm text-gray-600">{{ $product->product_code }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('products.show', $product) }}" class="font-medium text-blue-600 hover:text-blue-900 hover:underline">
                                    {{ $product->name }}
                                </a>
                                <div class="text-xs text-gray-500">{{ $product->brand }} • {{ $product->model }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="rounded bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                    {{ $product->category?->name ?? '—' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $product->status === 'Assigned' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $product->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $product->warehouse?->name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <form action="{{ route('products.assign', $product) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select name="employee_id" onchange="this.form.submit()" class="rounded border border-gray-300 px-2 py-1 text-sm focus:border-blue-500 focus:outline-none">
                                        <option value="">Unassigned</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ $product->employee_id == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }} ({{ $employee->employee_id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <a href="{{ route('products.show', $product) }}" class="mr-2 font-medium text-blue-600 hover:text-blue-800">Details</a>
                                <a href="{{ route('products.edit', $product) }}" class="mr-2 font-medium text-yellow-600 hover:text-yellow-700">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-655 hover:text-red-700" onclick="return confirm('Delete this product?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
