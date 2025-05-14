<?php

namespace App\Http\Controllers\Admin\Paket;

use App\Exports\PaketExport;
use App\Helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Paket\PaketRequest;
use App\Models\MstKategoriPaket;
use App\Models\TPaket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Excel;
use Throwable;

class PaketController extends Controller
{
    private $route              = 'admin.paket';
    private $namespace          = 'pages.admin.paket.';
    private $pagetitle          = 'Paket';
    private $information        = 'Halaman ini digunakan untuk mengatur data Paket.';
    private $table              = 'tPaket_table';
    private $permission         = 't_paket:';

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
        $post           = $request->input();
        $getData        = TPaket::select(
            't_pakets.*',
            'mst_kategori_pakets.nama AS kategori_nama',
            'mst_asramas.nama AS asrama_nama',
            'mst_santris.nama AS penerima_nama',
        );
        $where          = array();
        $join           = array();
        $leftjoin       = array(
            ['mst_asramas', 'mst_asramas.id', 't_pakets.asrama_id'],
            ['mst_kategori_pakets', 'mst_kategori_pakets.id', 't_pakets.kategori_id'],
            ['mst_santris', 'mst_santris.id', 't_pakets.penerima_id'],
        );
        $total_records  = $getData->count();
        $total_filtered = 0;
        $records        = array();
        $start          = intval($post['start']);
        $limit          = intval($post['length']);
        $awal           = $start;
        $columns        = array(
            1    => 't_pakets.nama',
            2    => 't_pakets.tgl_diterima',
            3    => 'mst_kategori_pakets.nama',
            4    => 'mst_asramas.nama',
            5    => 't_pakets.status',
            6    => 'mst_santris.nama'
        );

        if (isset($post['search']['value'])) {
            $getData->where(function ($q) use ($post) {
                $q->where('t_pakets.nama', 'LIKE', '%' . $post['search']['value'] . '%')
                    ->orWhere('t_pakets.tgl_diterima', 'LIKE', '%' . $post['search']['value'] . '%')
                    ->orWhere('mst_kategori_pakets.nama', 'LIKE', '%' . $post['search']['value'] . '%')
                    ->orWhere('mst_asramas.nama', 'LIKE', '%' . $post['search']['value'] . '%')
                    ->orWhere('mst_santris.nama', 'LIKE', '%' . $post['search']['value'] . '%');
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
            $getData->orderBy('created_at', 'desc');
        }

        $total_filtered = $getData->count();
        $results        = $getData
            ->limit($limit)
            ->offset($awal)
            ->get();

        $no                = 1 + $awal;
        foreach ($results as $result) {
            $btn_edit       = (!GlobalHelper::isHaveAbility($this->permission . 'update')) ? '' : '<a href="' . route($this->route . '.edit', $result->id) . '" class="btn btn-warning font-weight-bold btn-sm me-1"><i class="fa fa-pencil"></i> Edit</a>';
            $btn_delete     = (!GlobalHelper::isHaveAbility($this->permission . 'delete')) ? '' : '<a href="' . route($this->route . '.destroy', $result->id) . '" class="btn btn-danger font-weight-bold btn-sm me-1 btn-delete"><i class="fa fa-trash"></i> Hapus</a>';

            switch ($result->status) {
                case TPaket::STATE_BELUM:
                    $state = '<span class="badge bg-info">Belum Diambil</span>';
                    break;

                case TPaket::STATE_DIAMBIL:
                    $state = '<span class="badge bg-success">Sudah Diambil</span>';
                    break;

                default:
                    $state = '<span class="badge bg-secondary">' . $result->status . '</span>';
                    break;
            }

            if (GlobalHelper::isHaveAbility('mst_santri:read')) {
                $penerima = '<a target="_blank" href="' . route('admin.settings.santri.show', $result->penerima_id) . '">
                                <div class="py-1">' . $result->penerima_nama ?? '-' . '</div>
                            </a>';
            } else {
                $penerima = $result->penerima_nama;
            }

            $records[]      = array(
                'no'            => (string) $no,
                'nama'          => $result->nama,
                'tgl_diterima'  => $result->tgl_diterima,
                'kategori_nama' => $result->kategori_nama,
                'asrama_nama'   => $result->asrama_nama,
                'penerima_nama' => $penerima,
                'state'         => $state,
                'action'        => $btn_edit . $btn_delete
            );
            $no++;
        }

        $datarow         = array(
            'draw'               => $post['draw'],
            'recordsTotal'       => $total_records,
            'recordsFiltered'    => $total_filtered,
            'data'               => $records
        );

        return response()->json($datarow);
    }

    public function create()
    {
        GlobalHelper::mustHaveAbility($this->permission . 'create');
        $data['route']          = $this->route;
        $data['namespace']      = $this->namespace;
        $data['pagetitle']      = 'Tambah ' . $this->pagetitle;
        $data['permission']     = $this->permission;
        $data['information']    = $this->information;

        return view($this->namespace . 'create', $data);
    }

    public function store(PaketRequest $request)
    {
        GlobalHelper::mustHaveAbility($this->permission . 'create');
        try {
            DB::beginTransaction();
            $create                     = array();
            $create['nama']             = $request->nama;
            $create['tgl_diterima']     = $request->tgl_diterima;
            $create['kategori_id']      = $request->kategori_id;
            $create['asrama_id']        = $request->asrama_id;
            $create['penerima_id']      = $request->penerima_id;
            $create['pengirim']         = $request->pengirim;
            $create['isi_yg_disita']    = $request->isi_yg_disita;
            $create['status']           = $request->status;

            TPaket::create($create);

            DB::commit();

            return redirect()->route($this->route . '.index')->with('success', Lang::get('message.success_save_data'));
        } catch (Throwable $th) {
            DB::rollBack();

            return redirect()->route($this->route . '.create')->withInput()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        GlobalHelper::mustHaveAbility($this->permission . 'update');
        $data['route']          = $this->route;
        $data['namespace']      = $this->namespace;
        $data['pagetitle']      = 'Edit ' . $this->pagetitle;
        $data['permission']     = $this->permission;
        $data['information']    = $this->information;

        $data['record']         = TPaket::findOrFail($id);

        return view($this->namespace . 'edit', $data);
    }

    public function update($id, PaketRequest $request)
    {
        GlobalHelper::mustHaveAbility($this->permission . 'update');
        try {
            DB::beginTransaction();
            $update                     = array();
            $update['nama']             = $request->nama;
            $update['tgl_diterima']     = $request->tgl_diterima;
            $update['kategori_id']      = $request->kategori_id;
            $update['asrama_id']        = $request->asrama_id;
            $update['penerima_id']      = $request->penerima_id;
            $update['pengirim']         = $request->pengirim;
            $update['isi_yg_disita']    = $request->isi_yg_disita;
            $update['status']           = $request->status;

            TPaket::findOrFail($id)->update($update);

            DB::commit();

            return redirect()->route($this->route . '.index')->with('success', Lang::get('message.success_update_data'));
        } catch (Throwable $th) {
            DB::rollBack();

            return redirect()->route($this->route . '.edit', $id)->withInput()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        GlobalHelper::mustHaveAbility($this->permission . 'delete');
        try {
            DB::beginTransaction();
            TPaket::find($id)->delete();
            DB::commit();

            $datarow['status']    = 200;
            $datarow['message']   = Lang::get('message.success_delete_data');
        } catch (Throwable $th) {

            DB::rollBack();

            $datarow['status']    = $th->getCode();
            $datarow['message']   = $th->getMessage();
        } finally {
            return response()->json($datarow);
        }
    }

    public function options()
    {
        $totalRecord    = TPaket::count();
        $limit          = request('limit', 30);
        $offset         = ($limit * request('page', '1')) - $limit;
        $search         = request('q', '');

        $results    = TPaket::where('nama', 'like', '%' . $search . '%')
            ->orderBy('nama')
            ->limit($limit)
            ->offset($offset)
            ->get();

        $items = [];
        foreach ($results as $result) {
            $items[] = array(
                'id'    => $result->id,
                'text'  => $result->nama
            );
        }

        return response()->json([
            'items'         => $items,
            'total_count'   => $totalRecord
        ]);
    }

    public function export(Request $request)
    {
        $filename       = 'data-paket-' . date('Y-m-d h:i:s') . '.xlsx';
        $records        = TPaket::when($tgl_awal = $request->tgl_awal, fn($q) => $q->where('tgl_diterima', '>=', $tgl_awal))
            ->when($tgl_akhir   = $request->tgl_akhir, fn($q) => $q->where('tgl_diterima', '<=', $tgl_akhir))
            ->when($kategori_id = $request->kategori_id, fn($q) => $q->where('kategori_id', $kategori_id))
            ->get();

        $kategori       = 'Semua Kategori';
        if ($request->kategori_id) {
            $record     = MstKategoriPaket::find($request->kategori_id);

            if ($request) {
                $kategori   = $record->nama;
            }
        }

        $filter         = array(
            'tgl_awal'  => $request->tgl_awal,
            'tgl_akhir' => $request->tgl_akhir,
            'kategori'  => $kategori,
        );

        return (new PaketExport($filter, $records))->download($filename, Excel::XLSX);
    }
}
