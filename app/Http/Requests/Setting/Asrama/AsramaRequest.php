<?php

namespace App\Http\Requests\Setting\Asrama;

use Illuminate\Foundation\Http\FormRequest;

class AsramaRequest extends FormRequest
{
    /**
     * Declaration an attributes
     *
     * @var array
     */
    public function attributes()
    {
        return [
            'nama'          => 'Nama',
            'gedung'        => 'Gedung'
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
            'nama'          => 'required|max:100',
            'gedung'        => 'required|max:100',
        ];
    }
}
