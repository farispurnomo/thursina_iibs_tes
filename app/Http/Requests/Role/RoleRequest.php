<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Declaration an attributes
     *
     * @var array
     */
    public function attributes()
    {
        return [
            'name'              => 'Nama',
            'description'       => 'Deskripsi'
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
            'name'              => 'required',
            'description'       => 'nullable',
        ];
    }
}
