<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginAdminRequest extends FormRequest
{
    /**
     * Declaration an attributes
     *
     * @var array
     */
    public function attributes()
    {
        return [
            'email'            => 'Email',
            'password'         => 'Password'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'          => 'email',
            'password'       => 'required',
        ];
    }
}
