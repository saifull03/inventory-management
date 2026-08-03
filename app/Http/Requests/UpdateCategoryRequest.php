<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $category = $this->route('category') ?? $this->route('category');

        return [
            'name' => ['required', 'string', 'max:255'],
            'prefix' => ['required', 'string', 'max:20', Rule::unique('categories', 'prefix')->ignore($category?->id)],
            'description' => ['nullable', 'string'],
        ];
    }
}
