<?php

namespace App\Http\Requests\Paket;

use Illuminate\Foundation\Http\FormRequest;

class PaketRequest extends FormRequest
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
            'tgl_diterima'  => 'Tanggal',
            'kategori_id'   => 'Kategori',
            'asrama_id'     => 'Asrama',
            'penerima_id'   => 'Penerima',
            'pengirim'      => 'Pengirim',
            'isi_yg_disita' => 'Isi yang disita',
            'status'        => 'Status',
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
            'nama'          => 'required',
            'tgl_diterima'  => 'required|date',
            'kategori_id'   => 'required|exists:mst_kategori_pakets,id',
            'asrama_id'     => 'required|exists:mst_asramas,id',
            'penerima_id'   => 'required|exists:mst_santris,id',
            'pengirim'      => 'required|max:100',
            'isi_yg_disita' => 'nullable|max:200',
            'status'        => 'required|in:belum,diambil',
        ];
    }
}
