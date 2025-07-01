<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTagRequest extends FormRequest
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
                Rule::unique('tags', 'name')->ignore($this->tag->id ?? null),
            ],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Новое название тега',
                'example' => 'Laravel 11',
                'required' => true,
                'type' => 'string',
                'rules' => [
                    'required',
                    'string',
                    'max:100',
                    Rule::unique('tags', 'name')->ignore($this->tag->id ?? null)
                ],
                'notes' => 'Название должно быть уникальным (игнорируя текущий тег)'
            ]
        ];
    }
}
