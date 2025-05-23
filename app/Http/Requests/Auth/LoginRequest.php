<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Declaration an attributes
     *
     * @var array
     */
    public function attributes()
    {
        return [
            'phone'            => 'No Telepon',
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
            'phone'          => 'required',
            'password'       => 'required',
        ];
    }
}
