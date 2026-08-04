<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Categories
            </h2>
            <a href="{{ route('categories.create') }}" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">
                Add Category
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

        <div class="mb-4 flex items-center justify-between">
            <form method="GET" action="{{ route('categories.index') }}" class="flex w-full max-w-sm gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..." class="w-full rounded border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                <button type="submit" class="rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300">
                    Search
                </button>
            </form>
        </div>

        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Prefix</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-4 py-3">{{ $category->name }}</td>
                            <td class="px-4 py-3">{{ $category->prefix ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $category->description ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('categories.edit', $category) }}" class="mr-2 text-sm font-medium text-yellow-600 hover:text-yellow-755">Edit</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-755" onclick="return confirm('Delete this category?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($categories->hasPages())
            <div class="mt-4">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
