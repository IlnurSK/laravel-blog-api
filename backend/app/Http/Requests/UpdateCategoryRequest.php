<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'name')->ignore($this->route('category') ?? $this->category->id ?? null),
                ],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Новое название категории',
                'example' => 'Обновлённое название',
                'required' => true,
                'type' => 'string',
                'rules' => [
                    'required',
                    'string',
                    'max:100',
                    'unique:categories,name,' . ($this->category->id ?? 'NULL'),
                ],
                'notes' => 'Название должно быть уникальным (игнорируя текущую категорию)'
            ]
        ];
    }
}
