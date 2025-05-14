<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\KategoriPaket\KategoriPaketRequest;
use App\Models\MstKategoriPaket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Throwable;

class KategoriPaketController extends Controller
{
    private $route              = 'admin.settings.kategori_paket';
    private $namespace          = 'pages.admin.settings.kategori_paket.';
    private $pagetitle          = 'Kategori Paket';
    private $information        = 'Halaman ini digunakan untuk mengatur data Kategori Paket.';
    private $table              = 'mstKategoriPaket_table';
    private $permission         = 'mst_kategori_paket:';

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
        $getData        = MstKategoriPaket::query();
        $where          = array();
        $join           = array();
        $leftjoin       = array();
        $total_records  = $getData->count();
        $total_filtered = 0;
        $records        = array();
        $start          = intval($post['start']);
        $limit          = intval($post['length']);
        $awal           = $start;
        $columns        = array(
            1    => 'mst_kategori_pakets.nama'
        );

        if (isset($post['search']['value'])) {
            $getData->where('nama', 'LIKE', '%' . $post['search']['value'] . '%');
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

            $records[]      = array(
                'no'            => (string) $no,
                'nama'          => $result->nama,
                'kode'          => $result->kode,
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

    public function store(KategoriPaketRequest $request)
    {
        GlobalHelper::mustHaveAbility($this->permission . 'create');
        try {
            DB::beginTransaction();
            $create                 = array();
            $create['nama']         = $request->nama;

            MstKategoriPaket::create($create);

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

        $data['record']         = MstKategoriPaket::findOrFail($id);

        return view($this->namespace . 'edit', $data);
    }

    public function update($id, KategoriPaketRequest $request)
    {
        GlobalHelper::mustHaveAbility($this->permission . 'update');
        try {
            DB::beginTransaction();
            $update                 = array();
            $update['nama']         = $request->nama;

            MstKategoriPaket::findOrFail($id)->update($update);

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
            MstKategoriPaket::find($id)->delete();
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
        $totalRecord    = MstKategoriPaket::count();
        $limit          = request('limit', 30);
        $offset         = ($limit * request('page', '1')) - $limit;
        $search         = request('q', '');

        $results    = MstKategoriPaket::where('nama', 'like', '%' . $search . '%')
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
}
