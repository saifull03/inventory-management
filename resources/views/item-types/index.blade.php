<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Item Types
            </h2>
            <a href="{{ route('item-types.create') }}" class="rounded bg-blue-600 px-4 py-2 text-white">
                Add Item Type
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

        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($itemTypes as $itemType)
                        <tr>
                            <td class="px-4 py-3">{{ $itemType->name }}</td>
                            <td class="px-4 py-3">{{ $itemType->description ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('item-types.edit', $itemType) }}" class="mr-2 text-sm font-medium text-yellow-600">Edit</a>
                                <form action="{{ route('item-types.destroy', $itemType) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-red-600" onclick="return confirm('Delete this item type?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-sm text-gray-500">No item types yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
