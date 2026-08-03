<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'prefix' => ['required', 'string', 'max:20', 'unique:categories,prefix'],
            'description' => ['nullable', 'string'],
        ];
    }
}
