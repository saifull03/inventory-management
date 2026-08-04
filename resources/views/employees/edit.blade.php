<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Employee
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

        <form action="{{ route('employees.update', $employee) }}" method="POST" class="space-y-4 rounded-lg bg-white p-6 shadow-sm max-w-xl">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Employee ID</label>
                <input type="text" name="employee_id" value="{{ old('employee_id', $employee->employee_id) }}" readonly class="w-full rounded border-gray-300 bg-gray-100 text-gray-500 cursor-not-allowed">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $employee->name) }}" class="w-full rounded border-gray-300" required>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Department</label>
                <input type="text" name="department" value="{{ old('department', $employee->department) }}" class="w-full rounded border-gray-300" required>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Designation</label>
                <input type="text" name="designation" value="{{ old('designation', $employee->designation) }}" class="w-full rounded border-gray-300" required>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="w-full rounded border-gray-300" required>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" class="w-full rounded border-gray-300">
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded bg-green-600 px-4 py-2 text-white">Update Employee</button>
                <a href="{{ route('employees.index') }}" class="rounded bg-gray-500 px-4 py-2 text-white">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
