<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'login_username'=>'regex:/[\dA-z\.\-\_]{4,15}/',
            'login_password'=>'regex:/[\dA-z\.\-\_]{4,15}/',
        ];
    }

    public function messages()
    {
        return [
            'login_username.regex'=>'Dozvoljeni brojevi, slova i .-_ (4-15 karaktera)',
            'login_password.regex'=>'Dozvoljeni brojevi, slova i .-_ (4-15 karaktera)',
        ];
    }
}
