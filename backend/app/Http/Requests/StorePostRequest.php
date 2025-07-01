<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'tag_ids' => 'array',
            'tag_ids.*' => 'exists:tags,id',
            'is_published' => 'boolean',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'Заголовок поста',
                'example' => 'Новости Laravel 11',
                'required' => true,
                'rules' => 'string|max:255'
            ],
            'body' => [
                'description' => 'Содержание поста',
                'example' => 'Laravel 11 представляет новые возможности...',
                'required' => true,
                'rules' => 'string'
            ],
            'category_id' => [
                'description' => 'ID категории (опционально)',
                'example' => 1,
                'required' => false,
                'rules' => 'exists:categories,id'
            ],
            'tag_ids' => [
                'description' => 'Массив ID тегов для связи с постом',
                'example' => [1, 3, 5],
                'required' => false,
                'type' => 'array',
                'rules' => 'array|exists:tags,id'
            ],
            'tag_ids.*' => [
                'description' => 'ID отдельного тега',
                'example' => 1,
                'type' => 'integer',
                'rules' => 'exists:tags,id'
            ],
            'is_published' => [
                'description' => 'Флаг публикации',
                'example' => true,
                'required' => false,
                'rules' => 'boolean'
            ]
        ];
    }
}
