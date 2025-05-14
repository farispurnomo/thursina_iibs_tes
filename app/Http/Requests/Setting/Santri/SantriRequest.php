<?php

namespace App\Http\Requests\Setting\Santri;

use Illuminate\Foundation\Http\FormRequest;

class SantriRequest extends FormRequest
{
    /**
     * Declaration an attributes
     *
     * @var array
     */
    public function attributes()
    {
        return [
            'nis'           => 'NIS',
            'nama'          => 'Nama',
            'alamat'        => 'Alamat',
            'asrama_id'     => 'Asrama',
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
                    'nama'          => 'required|max:100',
                    'alamat'        => 'nullable|max:100',
                    'asrama_id'     => 'required|exists:mst_asramas,id',
                ];
                break;

            default:
                return [
                    'nis'           => 'required|unique:mst_santris,nis',
                    'nama'          => 'required|max:100',
                    'alamat'        => 'nullable|max:100',
                    'asrama_id'     => 'required|exists:mst_asramas,id',
                ];
                break;
        }
    }
}
