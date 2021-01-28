<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStore extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => 'required',
            'email'     => ['required', 'unique:users,email'],
            'password'  => ['required', 'min:6', 'max:10']
        ];
    }
}
