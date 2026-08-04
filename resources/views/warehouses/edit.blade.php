<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Warehouse
        </h2>
    </x-slot>

    <div class="p-6">

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 p-4 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('warehouses.update', $warehouse) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label>Warehouse Code</label>
                <input type="text"
                       name="code"
                       value="{{ old('code', $warehouse->code) }}"
                       readonly
                       class="bg-gray-100 border rounded w-full p-2 text-gray-500 cursor-not-allowed">
            </div>

            <div class="mb-4">
                <label>Warehouse Name</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $warehouse->name) }}"
                       class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label>Location</label>
                <input type="text"
                       name="location"
                       value="{{ old('location', $warehouse->location) }}"
                       class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label>Description</label>
                <textarea
                    name="description"
                    class="border rounded w-full p-2">{{ old('description', $warehouse->description) }}</textarea>
            </div>

            <button
                type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded">
                Update Warehouse
            </button>

            <a href="{{ route('warehouses.index') }}"
               class="ml-2 bg-gray-500 text-white px-4 py-2 rounded">
                Cancel
            </a>
        </form>

    </div>
</x-app-layout>