<?php

namespace App\Http\Requests\User;

use App\Rules\FileExtensionRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * Declaration an attributes
     *
     * @var array
     */
    public function attributes()
    {
        return [
            'name'          => 'Name',
            'email'         => 'Email',
            'password'      => 'Password',
            'role_id'       => 'Role',
            'image'         => 'Image',
            'phone'         => 'Phone',
            'address'       => 'Address'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'PUT':
                return [
                    'image'             => ['sometimes', 'mimes:jpeg,png,jpg', 'max:2048', new FileExtensionRule(['jpeg', 'png', 'jpg'])],
                    'role_id'           => 'required|exists:core_roles,id',
                    'name'              => 'required',
                    'phone'             => 'nullable',
                    'address'           => 'nullable'
                ];
                break;

            default:
                return [
                    'email'             => 'required|email|unique:core_users,id',
                    'password'          => 'required|min:8',
                    'role_id'           => 'required|exists:core_roles,id',
                    'image'             => ['sometimes', 'mimes:jpeg,png,jpg', 'max:2048', new FileExtensionRule(['jpeg', 'png', 'jpg'])],
                    'name'              => 'required',
                    'phone'             => 'nullable',
                    'address'           => 'nullable'
                ];
        }
    }
}
