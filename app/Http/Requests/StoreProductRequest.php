<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->input('category_id');
        $category = \App\Models\Category::find($categoryId);
        $isLicense = $category && (
            str_contains(strtolower($category->name), 'licence') || 
            str_contains(strtolower($category->name), 'license')
        );

        return [
            'product_code' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'brand' => $isLicense ? ['nullable', 'string', 'max:255'] : ['required', 'string', 'max:255'],
            'model' => $isLicense ? ['nullable', 'string', 'max:255'] : ['required', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'warehouse_id' => $isLicense ? ['nullable', 'exists:warehouses,id'] : ['required', 'exists:warehouses,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'item_type_id' => $isLicense ? ['nullable', 'exists:item_types,id'] : ['required', 'exists:item_types,id'],
            'status' => $isLicense ? ['nullable', Rule::in(['Available', 'Assigned', 'Maintenance', 'Damaged', 'Disposed', 'In Stock', 'Reserved'])] : ['required', Rule::in(['Available', 'Assigned', 'Maintenance', 'Damaged', 'Disposed', 'In Stock', 'Reserved'])],
            'purchase_date' => ['nullable', 'date'],
            'purchase_price' => ['nullable', 'numeric'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'employee_id' => ['nullable', 'exists:employees,id'],
            'custom_fields' => ['nullable', 'array'],
        ];
    }
}
