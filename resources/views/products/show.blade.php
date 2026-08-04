<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Product Details: {{ $product->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('products.index') }}" class="rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 transition">
                    Back to List
                </a>
                <a href="{{ route('products.edit', $product) }}" class="rounded bg-yellow-600 px-4 py-2 text-sm font-medium text-white hover:bg-yellow-700 transition">
                    Edit Product
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $isLicense = $product->category && (
            str_contains(strtolower($product->category->name), 'licence') || 
            str_contains(strtolower($product->category->name), 'license')
        );
        $customFields = $product->custom_fields ?: [];
    @endphp

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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left & Middle: Product General Information & Category Specifics -->
            <div class="lg:col-span-2 space-y-6">
                <!-- General Information Card -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-150 pb-3 mb-4">
                        General Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Product Code</span>
                            <span class="font-mono text-sm text-gray-900 bg-gray-50 px-2 py-0.5 rounded border border-gray-200 inline-block mt-1">
                                {{ $product->product_code }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</span>
                            <span class="text-sm font-medium text-gray-900 mt-1 block">{{ $product->name }}</span>
                        </div>
                        @if (!$isLicense)
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Brand / Model</span>
                            <span class="text-sm text-gray-900 mt-1 block">{{ $product->brand }} • {{ $product->model }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Serial Number</span>
                            <span class="text-sm text-gray-900 mt-1 block font-mono">{{ $product->serial_number ?: '—' }}</span>
                        </div>
                        @endif
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</span>
                            <span class="mt-1 inline-block rounded bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                {{ $product->category?->name ?? '—' }}
                            </span>
                        </div>
                        @if (!$isLicense)
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Item Type</span>
                            <span class="text-sm text-gray-900 mt-1 block">{{ $product->itemType?->name ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Warehouse</span>
                            <span class="text-sm text-gray-900 mt-1 block">{{ $product->warehouse?->name ?? '—' }}</span>
                        </div>
                        @endif
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Created By</span>
                            <span class="text-sm text-gray-900 mt-1 block">{{ $product->creator?->name ?? 'System' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Purchase Date</span>
                            <span class="text-sm text-gray-900 mt-1 block">
                                {{ $product->purchase_date ? \Illuminate\Support\Carbon::parse($product->purchase_date)->format('M d, Y') : '—' }}
                            </span>
                        </div>
                        <div>
                            <span id="purchase_price_label" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $isLicense ? 'Purchase Cost' : 'Purchase Price' }}</span>
                            <span class="text-sm text-gray-900 mt-1 block font-semibold text-green-700">
                                {{ $product->purchase_price ? '$' . number_format($product->purchase_price, 2) : '—' }}
                            </span>
                        </div>
                    </div>
                    @if ($product->description)
                        <div class="mt-6 border-t border-gray-100 pt-4">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">{{ $isLicense ? 'Notes' : 'Description' }}</span>
                            <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded border border-gray-100 whitespace-pre-line">{{ $product->description }}</p>
                        </div>
                    @endif
                </div>

                <!-- License Information Card (Conditionally Rendered) -->
                @if ($isLicense || !empty($customFields))
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between border-b border-gray-150 pb-3 mb-4">
                            <h3 class="text-lg font-bold text-gray-900">
                                License Specifications
                            </h3>
                            <span class="rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-800">
                                License Asset
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <div>
                                <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Company</span>
                                <span class="text-sm text-gray-900 mt-1 block">{{ $customFields['company'] ?? '—' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Manufacturer</span>
                                <span class="text-sm text-gray-900 mt-1 block">{{ $customFields['manufacturer'] ?? '—' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Seats</span>
                                <span class="text-sm text-gray-900 mt-1 block font-semibold">{{ $customFields['seats'] ?? '—' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Min. QTY Alert Level</span>
                                <span class="text-sm text-gray-900 mt-1 block">{{ $customFields['min_qty'] ?? '—' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Licensed To Name</span>
                                <span class="text-sm text-gray-900 mt-1 block">{{ $customFields['licensed_to'] ?? '—' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Licensed To Email</span>
                                <span class="text-sm text-gray-900 mt-1 block">
                                    @if(!empty($customFields['licensed_to_email']))
                                        <a href="mailto:{{ $customFields['licensed_to_email'] }}" class="text-blue-600 hover:underline">{{ $customFields['licensed_to_email'] }}</a>
                                    @else
                                        —
                                    @endif
                                </span>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider font-medium">Reassignable</span>
                                <span class="text-sm text-gray-900 mt-1 block">{{ $customFields['reassignable'] ?? 'Yes' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Maintained</span>
                                <span class="text-sm text-gray-900 mt-1 block">{{ $customFields['maintained'] ?? '—' }}</span>
                            </div>

                            <!-- Purchase / Order Information -->
                            <div class="col-span-1 md:col-span-2 border-t border-gray-100 pt-4 mt-2">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Order & Cost Details</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <span class="block text-xs font-semibold text-gray-500">Supplier</span>
                                        <span class="text-sm text-gray-900 mt-1 block">{{ $customFields['supplier'] ?? '—' }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold text-gray-500">Order Number</span>
                                        <span class="text-sm text-gray-900 mt-1 block">{{ $customFields['order_number'] ?? '—' }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold text-gray-500">Purchase Order #</span>
                                        <span class="text-sm text-gray-900 mt-1 block font-mono">{{ $customFields['purchase_order_number'] ?? '—' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Dates Section -->
                            <div class="col-span-1 md:col-span-2 border-t border-gray-100 pt-4 mt-2">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Key Dates & Financials</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <span class="block text-xs font-semibold text-gray-500">Expiration Date</span>
                                        <span class="text-sm text-gray-900 mt-1 block">
                                            @if(!empty($customFields['expiration_date']))
                                                <span class="font-medium @if(\Illuminate\Support\Carbon::parse($customFields['expiration_date'])->isPast()) text-red-655 @endif">
                                                    {{ \Illuminate\Support\Carbon::parse($customFields['expiration_date'])->format('M d, Y') }}
                                                    @if(\Illuminate\Support\Carbon::parse($customFields['expiration_date'])->isPast())
                                                        <span class="text-[10px] uppercase font-bold bg-red-100 text-red-800 px-1.5 py-0.5 rounded ml-1">Expired</span>
                                                    @endif
                                                </span>
                                            @else
                                                —
                                            @endif
                                        </span>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold text-gray-500">Termination Date</span>
                                        <span class="text-sm text-gray-900 mt-1 block">
                                            {{ !empty($customFields['termination_date']) ? \Illuminate\Support\Carbon::parse($customFields['termination_date'])->format('M d, Y') : '—' }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-semibold text-gray-500">Depreciation</span>
                                        <span class="text-sm text-gray-900 mt-1 block">{{ $customFields['depreciation'] ?? '—' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Key Field (With Secure Toggle) -->
                            <div class="col-span-1 md:col-span-2 border-t border-gray-100 pt-4 mt-2">
                                <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Product Key</span>
                                <div class="flex items-center gap-2 bg-gray-50 p-3 rounded border border-gray-150">
                                    <input type="password" id="productKeyField" readonly value="{{ $customFields['product_key'] ?? '' }}" class="flex-grow font-mono text-sm bg-transparent border-none p-0 focus:ring-0 text-gray-800" placeholder="No Product Key provided">
                                    @if(!empty($customFields['product_key']))
                                        <button type="button" id="toggleProductKeyBtn" class="text-xs font-semibold text-blue-600 hover:text-blue-800 focus:outline-none">
                                            Show Key
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if(!empty($customFields['notes']))
                            <div class="mt-6 border-t border-gray-100 pt-4">
                                <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">License Notes</span>
                                <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded border border-gray-100 whitespace-pre-line">{{ $customFields['notes'] }}</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Right Column: Assignment Card & Checkout Form -->
            <div class="space-y-6">
                <!-- Status & Current Assignment Card -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-150 pb-3 mb-4">
                        Asset Status & Assignment
                    </h3>

                    <!-- Status Display -->
                    <div class="mb-6">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-2">Current Status</span>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold leading-5 {{ $product->status === 'Assigned' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ $product->status }}
                            </span>
                            @if ($product->employee_id)
                                <span class="text-xs text-gray-500">
                                    Assigned to {{ $product->employee->name }}
                                </span>
                            @else
                                <span class="text-xs text-gray-500">
                                    Ready for deployment
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Current Employee Information -->
                    @if ($product->employee)
                        <div class="mb-6 bg-blue-50/50 rounded-lg p-4 border border-blue-100/50">
                            <span class="text-xs font-bold text-blue-800 uppercase tracking-wider block mb-3">Checked Out To</span>
                            
                            <div class="space-y-2">
                                <div>
                                    <span class="text-xs text-gray-500 block">Employee Name</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $product->employee->name }}</span>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <span class="text-xs text-gray-500 block">ID</span>
                                        <span class="text-xs font-mono text-gray-900">{{ $product->employee->employee_id }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 block">Designation</span>
                                        <span class="text-xs text-gray-900">{{ $product->employee->designation ?: '—' }}</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <span class="text-xs text-gray-500 block">Department</span>
                                        <span class="text-xs text-gray-900">{{ $product->employee->department ?: '—' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 block">Phone</span>
                                        <span class="text-xs text-gray-900">{{ $product->employee->phone ?: '—' }}</span>
                                    </div>
                                </div>
                                @if ($product->employee->email)
                                    <div>
                                        <span class="text-xs text-gray-500 block">Email Address</span>
                                        <a href="mailto:{{ $product->employee->email }}" class="text-xs text-blue-600 hover:underline">{{ $product->employee->email }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Checkin (Unassign) Form -->
                        <form action="{{ route('products.assign', $product) }}" method="POST" class="mt-4">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="employee_id" value="">
                            <button type="submit" class="w-full text-center rounded bg-red-600 hover:bg-red-700 text-white font-medium text-sm py-2.5 transition shadow-sm">
                                Checkin / Unassign Product
                            </button>
                        </form>
                    @else
                        <!-- Checkout (Assign) Form -->
                        <div class="mt-4">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-2">Checkout to Employee</span>
                            <form action="{{ route('products.assign', $product) }}" method="POST" class="space-y-3">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <select name="employee_id" required class="w-full rounded border-gray-300 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                        <option value="">Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">
                                                {{ $employee->name }} ({{ $employee->employee_id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="w-full text-center rounded bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm py-2.5 transition shadow-sm">
                                    Checkout / Assign Product
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Dangerous Actions Card -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900 border-b border-gray-150 pb-2 mb-3">
                        Danger Zone
                    </h3>
                    <p class="text-xs text-gray-500 mb-4">
                        Deleting this asset is permanent. If the asset is currently checked out to a user, deletion will be blocked to maintain data integrity.
                    </p>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-center rounded border border-red-200 hover:bg-red-50 text-red-600 font-medium text-sm py-2 transition">
                            Delete Product Asset
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(!empty($customFields['product_key']))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const keyInput = document.getElementById('productKeyField');
                const toggleBtn = document.getElementById('toggleProductKeyBtn');
                
                if (keyInput && toggleBtn) {
                    toggleBtn.addEventListener('click', function () {
                        if (keyInput.type === 'password') {
                            keyInput.type = 'text';
                            toggleBtn.textContent = 'Hide Key';
                        } else {
                            keyInput.type = 'password';
                            toggleBtn.textContent = 'Show Key';
                        }
                    });
                }
            });
        </script>
    @endif
</x-app-layout>
