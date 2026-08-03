<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItemTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $itemType = $this->route('itemType') ?? $this->route('item_type');

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('item_types', 'name')->ignore($itemType?->id)],
            'description' => ['nullable', 'string'],
        ];
    }
}
