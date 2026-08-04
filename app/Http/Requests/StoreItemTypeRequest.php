<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:item_types,name'],
            'prefix' => ['required', 'string', 'max:50', 'unique:item_types,prefix'],
            'description' => ['nullable', 'string'],
        ];
    }
}
