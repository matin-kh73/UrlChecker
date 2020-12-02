<?php

namespace App\Http\Requests;

use App\Services\Requests\RequestService;

class RegisterRequest extends RequestService
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'name' => 'required|string'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    protected function messages()
    {
        return [];
    }
}
