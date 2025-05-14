<?php

namespace App\Http\Requests\Profile;

use App\Rules\FileExtensionRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Declaration an attributes
     *
     * @var array
     */
    public function attributes()
    {
        return [
            'name'      => 'Name',
            'password'  => 'Password',
            'image'     => 'Image',
            'phone'     => 'Phone',
            'address'   => 'Address'
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
            'name'      => 'required',
            'password'  => 'nullable|min:6',
            // 'image'     => 'sometimes|mimes:jpeg,png,jpg|max:2048',
            'image'     => ['sometimes', 'mimes:jpeg,png,jpg', 'max:2048', new FileExtensionRule(['jpeg', 'png', 'png'])],
            'phone'     => 'nullable',
            'address'   => 'nullable'
        ];
    }
}
