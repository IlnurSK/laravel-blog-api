<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'body' => 'required|string|max:1000',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'body' => [
                'description' => 'Текст комментария',
                'example' => 'Это очень полезная статья, спасибо автору!',
                'required' => true,
                'type' => 'string',
                'rules' => 'required|string|max:1000',
                'notes' => 'Максимальная длина - 1000 символов'
            ]
        ];
    }
}
