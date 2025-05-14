<?php

namespace App\Http\Requests\Setting\Santri;

use App\Rules\FileExtensionRule;
use Illuminate\Foundation\Http\FormRequest;

class SantriImportRequest extends FormRequest
{
    /**
     * Declaration an attributes
     *
     * @var array
     */
    public function attributes()
    {
        return [
            'file'  => 'File',
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
            'file'  => ['required', 'mimes:xlsx', 'max:2048', new FileExtensionRule(['xlsx'])],
        ];
    }
}
