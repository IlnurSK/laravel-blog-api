<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Полное имя пользователя',
                'example' => 'Иван Иванов',
                'required' => true,
                'rules' => 'string|max:255',
                'type' => 'string'
            ],
            'email' => [
                'description' => 'Уникальный email пользователя',
                'example' => 'user@example.com',
                'required' => true,
                'rules' => 'email|max:255|unique:users,email',
                'type' => 'string'
            ],
            'password' => [
                'description' => 'Пароль (мин. 8 символов)',
                'example' => 'Secret123', // Фиксированное значение
                'required' => true
            ],
            'password_confirmation' => [
                'description' => 'Подтверждение пароля',
                'example' => 'Secret123', // Точно такое же!
                'required' => true
            ]
        ];
    }
}
