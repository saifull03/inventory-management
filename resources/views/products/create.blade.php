<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Product
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

        <form action="{{ route('products.store') }}" method="POST" class="space-y-4 rounded-lg bg-white p-6 shadow-sm">
            @csrf

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" id="category_select" class="w-full rounded border-gray-300" required>
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" data-name="{{ $category->name }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Product Code</label>
                    <input type="text" name="product_code" value="{{ old('product_code') }}" readonly placeholder="[Auto-generated]" class="w-full rounded border-gray-300 bg-gray-100 text-gray-500 cursor-not-allowed" required>
                </div>
                <div class="col-span-2">
                    <label class="mb-1 block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded border-gray-300" required>
                </div>

                <!-- Hardware-only fields container -->
                <div id="hardware-fields-container" class="col-span-2 grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Brand</label>
                        <input type="text" name="brand" id="brand_input" value="{{ old('brand') }}" class="w-full rounded border-gray-300" required>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Model</label>
                        <input type="text" name="model" id="model_input" value="{{ old('model') }}" class="w-full rounded border-gray-300" required>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Serial number</label>
                        <input type="text" name="serial_number" value="{{ old('serial_number') }}" class="w-full rounded border-gray-300">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status_select" class="w-full rounded border-gray-300">
                            <option value="Available">Available</option>
                            <option value="Assigned">Assigned</option>
                            <option value="Maintenance">Maintenance</option>
                            <option value="Damaged">Damaged</option>
                            <option value="Disposed">Disposed</option>
                            <option value="In Stock">In Stock</option>
                            <option value="Reserved">Reserved</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Assigned Employee</label>
                        <select name="employee_id" id="employee_select" class="w-full rounded border-gray-300">
                            <option value="">Select Employee (Optional)</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }} ({{ $employee->employee_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Warehouse</label>
                        <select name="warehouse_id" id="warehouse_input" class="w-full rounded border-gray-300" required>
                            <option value="">Select warehouse</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Item Type</label>
                        <select name="item_type_id" id="item_type_input" class="w-full rounded border-gray-300" required>
                            <option value="">Select item type</option>
                            @foreach ($itemTypes as $itemType)
                                <option value="{{ $itemType->id }}" {{ old('item_type_id') == $itemType->id ? 'selected' : '' }}>{{ $itemType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Always visible purchase fields -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Purchase date</label>
                    <input type="date" name="purchase_date" value="{{ old('purchase_date') }}" class="w-full rounded border-gray-300">
                </div>
                <div>
                    <label id="purchase_price_label" class="mb-1 block text-sm font-medium text-gray-700">Purchase price</label>
                    <input type="number" step="0.01" name="purchase_price" value="{{ old('purchase_price') }}" class="w-full rounded border-gray-300">
                </div>

                <!-- License Category Fields (dynamically toggled) -->
                <div id="license-fields-container" class="hidden col-span-2 border-t border-gray-200 pt-6 mt-4">
                    <h3 class="text-base font-semibold text-gray-800 mb-4">License Information</h3>
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Company</label>
                            <input type="text" name="custom_fields[company]" value="{{ old('custom_fields.company') }}" class="w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Seats</label>
                            <input type="number" name="custom_fields[seats]" value="{{ old('custom_fields.seats') }}" class="w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Min. QTY</label>
                            <input type="number" name="custom_fields[min_qty]" value="{{ old('custom_fields.min_qty') }}" class="w-full rounded border-gray-300">
                            <span class="text-xs text-gray-500 block mt-1">Minimum number of this item that should be available for checkout before an alert gets triggered. Leave blank if you do not wish to receive alerts for low inventory.</span>
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Product Key</label>
                            <input type="text" name="custom_fields[product_key]" value="{{ old('custom_fields.product_key') }}" class="w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Manufacturer</label>
                            <input type="text" name="custom_fields[manufacturer]" value="{{ old('custom_fields.manufacturer') }}" class="w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Licensed To</label>
                            <input type="text" name="custom_fields[licensed_to]" value="{{ old('custom_fields.licensed_to') }}" class="w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Licensed to Email</label>
                            <input type="email" name="custom_fields[licensed_to_email]" value="{{ old('custom_fields.licensed_to_email') }}" class="w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Reassignable</label>
                            <select name="custom_fields[reassignable]" class="w-full rounded border-gray-300">
                                <option value="Yes" {{ old('custom_fields.reassignable') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ old('custom_fields.reassignable') == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Supplier</label>
                            <input type="text" name="custom_fields[supplier]" value="{{ old('custom_fields.supplier') }}" class="w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Order Number</label>
                            <input type="text" name="custom_fields[order_number]" value="{{ old('custom_fields.order_number') }}" class="w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Expiration Date</label>
                            <input type="date" name="custom_fields[expiration_date]" value="{{ old('custom_fields.expiration_date') }}" class="w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Termination Date</label>
                            <input type="date" name="custom_fields[termination_date]" value="{{ old('custom_fields.termination_date') }}" class="w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Purchase Order Number</label>
                            <input type="text" name="custom_fields[purchase_order_number]" value="{{ old('custom_fields.purchase_order_number') }}" class="w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Depreciation</label>
                            <input type="text" name="custom_fields[depreciation]" value="{{ old('custom_fields.depreciation') }}" class="w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Maintained</label>
                            <select name="custom_fields[maintained]" class="w-full rounded border-gray-300">
                                <option value="No" {{ old('custom_fields.maintained') == 'No' ? 'selected' : '' }}>No</option>
                                <option value="Yes" {{ old('custom_fields.maintained') == 'Yes' ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" class="w-full rounded border-gray-300">{{ old('description') }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">Save Product</button>
                <a href="{{ route('products.index') }}" class="rounded bg-gray-500 px-4 py-2 text-white hover:bg-gray-600 transition">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categorySelect = document.getElementById('category_select');
            const productCodeInput = document.querySelector('input[name="product_code"]');
            const itemTypeSelect = document.getElementById('item_type_input');
            const employeeSelect = document.getElementById('employee_select');
            const statusSelect = document.getElementById('status_select');
            const licenseFields = document.getElementById('license-fields-container');
            const hardwareFields = document.getElementById('hardware-fields-container');
            const purchasePriceLabel = document.getElementById('purchase_price_label');

            const brandInput = document.getElementById('brand_input');
            const modelInput = document.getElementById('model_input');
            const warehouseSelect = document.getElementById('warehouse_input');

            function fetchProductCode() {
                const categoryId = categorySelect.value;
                const itemTypeId = itemTypeSelect ? itemTypeSelect.value : null;

                if (!categoryId && !itemTypeId) {
                    productCodeInput.value = '';
                    return;
                }

                productCodeInput.value = 'Generating...';

                let url = `/products/next-code?category_id=${categoryId}`;
                if (itemTypeId) {
                    url += `&item_type_id=${itemTypeId}`;
                }

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        productCodeInput.value = data.code;
                    })
                    .catch(error => {
                        console.error('Error fetching product code:', error);
                        productCodeInput.value = '';
                    });
            }

            if (itemTypeSelect) {
                itemTypeSelect.addEventListener('change', fetchProductCode);
            }

            if (employeeSelect && statusSelect) {
                employeeSelect.addEventListener('change', function () {
                    if (this.value) {
                        statusSelect.value = 'Assigned';
                    } else if (statusSelect.value === 'Assigned') {
                        statusSelect.value = 'Available';
                    }
                });
            }

            function toggleLicenseFields() {
                const selectedOption = categorySelect.options[categorySelect.selectedIndex];
                const categoryName = selectedOption ? (selectedOption.getAttribute('data-name') || '') : '';
                const isLicense = categoryName.toLowerCase().includes('licence') || categoryName.toLowerCase().includes('license');
                
                if (isLicense) {
                    licenseFields.classList.remove('hidden');
                    hardwareFields.classList.add('hidden');

                    if (brandInput) brandInput.removeAttribute('required');
                    if (modelInput) modelInput.removeAttribute('required');
                    if (warehouseSelect) warehouseSelect.removeAttribute('required');
                    if (itemTypeSelect) itemTypeSelect.removeAttribute('required');

                    if (purchasePriceLabel) purchasePriceLabel.textContent = 'Purchase Cost (USD)';
                } else {
                    licenseFields.classList.add('hidden');
                    hardwareFields.classList.remove('hidden');

                    if (brandInput) brandInput.setAttribute('required', 'required');
                    if (modelInput) modelInput.setAttribute('required', 'required');
                    if (warehouseSelect) warehouseSelect.setAttribute('required', 'required');
                    if (itemTypeSelect) itemTypeSelect.setAttribute('required', 'required');

                    if (purchasePriceLabel) purchasePriceLabel.textContent = 'Purchase price';
                }

                fetchProductCode();
            }

            if (categorySelect && licenseFields) {
                categorySelect.addEventListener('change', toggleLicenseFields);
                toggleLicenseFields();
            }
        });
    </script>
</x-app-layout>
