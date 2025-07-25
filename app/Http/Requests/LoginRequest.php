<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Определить, имеет ли пользователь право сделать этот запрос.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Получить правила проверки, применяемые к запросу.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}
