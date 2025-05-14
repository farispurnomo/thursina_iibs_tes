<?php

namespace App\Http\Requests\Setting\KategoriPaket;

use Illuminate\Foundation\Http\FormRequest;

class KategoriPaketRequest extends FormRequest
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
        ];
    }
}
