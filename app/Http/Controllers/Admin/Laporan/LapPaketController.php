<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Models\TPaket;
use Illuminate\Http\Request;

class LapPaketController extends Controller
{
    private $route              = 'admin.laporan.paket';
    private $namespace          = 'pages.admin.laporan.paket.';
    private $pagetitle          = 'Laporan Paket';
    private $information        = 'Halaman ini digunakan untuk melihat laporan paket.';
    private $table              = 'lapPaket_table';
    private $permission         = 'lap_paket:';

    public function index()
    {
        GlobalHelper::mustHaveAbility($this->permission . 'read');
        $data['route']          = $this->route;
        $data['table']          = $this->table;
        $data['namespace']      = $this->namespace;
        $data['pagetitle']      = $this->pagetitle;
        $data['permission']     = $this->permission;
        $data['information']    = $this->information;

        return view($this->namespace . 'index', $data);
    }

    public function paginate(Request $request)
    {
        GlobalHelper::mustHaveAbility($this->permission . 'read');
        $post               = $request->input();
        $getData            = TPaket::select(
            't_pakets.*',
            'mst_kategori_pakets.nama AS kategori_nama',
            'mst_asramas.nama AS asrama_nama'
        );
        $where              = array();
        $join               = array();
        $leftjoin           = array(
            ['mst_asramas', 'mst_asramas.id', 't_pakets.asrama_id'],
            ['mst_kategori_pakets', 'mst_kategori_pakets.id', 't_pakets.kategori_id'],
        );
        $total_records      = $getData->count();
        $total_filtered     = 0;
        $records            = array();
        $start              = intval($post['start']);
        $limit              = intval($post['length']);
        $awal               = $start;
        $columns            = array(
            1    => 't_pakets.nama',
            2    => 't_pakets.tgl_diterima',
            3    => 'mst_kategori_pakets.nama',
            4    => 'mst_asramas.nama',
            5    => 't_pakets.isi_yg_disita'
        );

        if (isset($post['search']['value'])) {
            $getData->where(function ($q) use ($post) {
                $q->where('t_pakets.nama', 'LIKE', '%' . $post['search']['value'] . '%')
                    ->orWhere('t_pakets.tgl_diterima', 'LIKE', '%' . $post['search']['value'] . '%')
                    ->orWhere('mst_kategori_pakets.nama', 'LIKE', '%' . $post['search']['value'] . '%')
                    ->orWhere('mst_asramas.nama', 'LIKE', '%' . $post['search']['value'] . '%')
                    ->orWhere('t_pakets.isi_yg_disita', 'LIKE', '%' . $post['search']['value'] . '%');
            });
        }

        if (isset($post['filter']['tgl_awal'])) {
            $getData    = $getData->whereDate('t_pakets.tgl_diterima', '>=', $post['filter']['tgl_awal']);
        }

        if (isset($post['filter']['tgl_akhir'])) {
            $getData    = $getData->whereDate('t_pakets.tgl_diterima', '<=', $post['filter']['tgl_akhir']);
        }

        if (isset($post['filter']['kategori_id'])) {
            $getData    = $getData->where('t_pakets.kategori_id', $post['filter']['kategori_id']);
        }

        if (isset($post['filter']['is_sita'])) {
            if ($post['filter']['is_sita']) {
                $getData    = $getData->whereNotNull('isi_yg_disita');
            } else {
                $getData    = $getData->whereNull('isi_yg_disita');
            }
        }

        if (!empty($where)) {
            foreach ($where as $value) {
                $getData  = $getData->where($value[0], $value[1], $value[2]);
            }
        }

        if (!empty($join)) {
            foreach ($join as $value) {
                $getData  = $getData->join($value[0], $value[1], $value[2]);
            }
        }
        if (!empty($leftjoin)) {
            foreach ($leftjoin as $value) {
                $getData  = $getData->leftJoin($value[0], $value[1], $value[2]);
            }
        }

        if (isset($post['order'][0]['column'])) {
            $getData->orderBy($columns[$post['order'][0]['column']], $post['order'][0]['dir']);
        } else {
            $getData->orderByDesc('t_pakets.tgl_diterima');
        }

        $total_filtered = $getData->count();
        $results        = $getData
            ->limit($limit)
            ->offset($awal)
            ->get();

        $no                = 1 + $awal;
        foreach ($results as $result) {
            $records[]        = array(
                'no'            => (string) $no,
                'nama'          => $result->nama,
                'tgl_diterima'  => $result->tgl_diterima,
                'kategori_nama' => $result->kategori_nama,
                'asrama_nama'   => $result->asrama_nama,
                'isi_yg_disita' => $result->isi_yg_disita
            );
            $no++;
        }

        $datarow         = array(
            'draw'              => $post['draw'],
            'recordsTotal'      => $total_records,
            'recordsFiltered'   => $total_filtered,
            'data'              => $records
        );

        return response()->json($datarow);
    }
}
