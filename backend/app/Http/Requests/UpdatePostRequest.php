<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->id() === $this->post->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'body' => 'sometimes|required|string',
            'category_id' => 'nullable|exists:categories,id',
            'tag_ids' => 'sometimes|array',
            'tag_ids.*' => 'exists:tags,id',
            'is_published' => 'sometimes|boolean',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'Заголовок поста',
                'example' => 'Новости Laravel 11',
                'required' => false, // sometimes|required
                'type' => 'string',
                'rules' => 'string|max:255',
                'notes' => 'Обязателен при обновлении, если передан'
            ],
            'body' => [
                'description' => 'Содержимое поста',
                'example' => 'Laravel 11 представляет новые функции...',
                'required' => false, // sometimes|required
                'type' => 'string',
                'notes' => 'Обязателен при создании, если передан'
            ],
            'category_id' => [
                'description' => 'ID связанной категории',
                'example' => 1,
                'required' => false, // nullable
                'type' => 'integer',
                'rules' => 'exists:categories,id'
            ],
            'tag_ids' => [
                'description' => 'Массив ID тегов для обновления связей',
                'example' => [1, 3],
                'required' => false,
                'type' => 'array',
                'rules' => 'sometimes|array|exists:tags,id'
            ],
            'tag_ids.*' => [
                'description' => 'ID конкретного тега',
                'example' => 1,
                'type' => 'integer',
                'rules' => 'exists:tags,id'
            ],
            'is_published' => [
                'description' => 'Флаг публикации',
                'example' => true,
                'required' => false, // sometimes
                'type' => 'boolean',
                'notes' => 'Если не передано, сохраняется текущее значение'
            ]
        ];
    }
}
