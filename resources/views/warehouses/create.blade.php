<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Warehouse
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
        <form action="{{ route('warehouses.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label>Warehouse Code</label><br>
                <input type="text" name="code" class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label>Warehouse Name</label><br>
                <input type="text" name="name" class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label>Location</label><br>
                <input type="text" name="location" class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label>Description</label><br>
                <textarea name="description" class="border rounded w-full p-2"></textarea>
            </div>

            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded">
                Save Warehouse
            </button>
        </form>
    </div>
</x-app-layout>