<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Item Type
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

        <form action="{{ route('item-types.update', $itemType) }}" method="POST" class="space-y-4 rounded-lg bg-white p-6 shadow-sm">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $itemType->name) }}" class="w-full rounded border-gray-300" required>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Prefix</label>
                <input type="text" name="prefix" value="{{ old('prefix', $itemType->prefix) }}" class="w-full rounded border-gray-300" required>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" class="w-full rounded border-gray-300">{{ old('description', $itemType->description) }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded bg-green-600 px-4 py-2 text-white">Update Item Type</button>
                <a href="{{ route('item-types.index') }}" class="rounded bg-gray-500 px-4 py-2 text-white">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
