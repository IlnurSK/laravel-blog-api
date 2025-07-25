<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name' => 'required|string|max:100|unique:categories,name',
        ];
    }
}
