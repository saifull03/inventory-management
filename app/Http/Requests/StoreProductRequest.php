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
        return [
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'warehouse_id' => ['required', 'exists:warehouses,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'item_type_id' => ['required', 'exists:item_types,id'],
            'status' => ['required', Rule::in(['Available', 'Assigned', 'Maintenance', 'Damaged', 'Disposed', 'In Stock', 'Reserved'])],
            'purchase_date' => ['nullable', 'date'],
            'purchase_price' => ['nullable', 'numeric'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
