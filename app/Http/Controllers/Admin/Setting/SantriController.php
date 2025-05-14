<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Exports\SantriExport;
use App\Helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\Santri\SantriImportRequest;
use App\Http\Requests\Setting\Santri\SantriRequest;
use App\Imports\SantriImport;
use App\Models\MstAsrama;
use App\Models\MstSantri;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;
use Throwable;

class SantriController extends Controller
{
    private $route              = 'admin.settings.santri';
    private $namespace          = 'pages.admin.settings.santri.';
    private $pagetitle          = 'Santri';
    private $information        = 'Halaman ini digunakan untuk mengatur data Kategori Paket.';
    private $table              = 'mstSantri_table';
    private $permission         = 'mst_santri:';

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
        $getData        = MstSantri::select(
            'mst_santris.*',
            'mst_asramas.nama AS asrama_nama'
        );
        $where          = array();
        $join           = array();
        $leftjoin       = array(
            ['mst_asramas', 'mst_asramas.id', 'mst_santris.asrama_id']
        );
        $total_records  = $getData->count();
        $total_filtered = 0;
        $records        = array();
        $start          = intval($post['start']);
        $limit          = intval($post['length']);
        $awal           = $start;
        $columns        = array(
            1    => 'mst_santris.nis',
            2    => 'mst_santris.nama',
            3    => 'mst_santris.alamat',
            4    => 'mst_asramas.nama',
            5    => 'mst_santris.total_paket'
        );

        if (isset($post['search']['value'])) {
            $getData
                ->where(function ($q) use ($post) {
                    $q->where('mst_santris.nis', 'LIKE', '%' . $post['search']['value'] . '%')
                        ->orWhere('mst_santris.nama', 'LIKE', '%' . $post['search']['value'] . '%')
                        ->orWhere('mst_santris.alamat', 'LIKE', '%' . $post['search']['value'] . '%')
                        ->orWhere('mst_asramas.nama', 'LIKE', '%' . $post['search']['value'] . '%');
                });
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
            $btn_detail     = (!GlobalHelper::isHaveAbility($this->permission . 'read')) ? '' : '<a href="' . route($this->route . '.show', $result->id) . '" class="btn btn-info font-weight-bold btn-sm me-1"><i class="fa fa-eye"></i> Detail</a>';
            $btn_edit       = (!GlobalHelper::isHaveAbility($this->permission . 'update')) ? '' : '<a href="' . route($this->route . '.edit', $result->id) . '" class="btn btn-warning font-weight-bold btn-sm me-1"><i class="fa fa-pencil"></i> Edit</a>';
            $btn_delete     = (!GlobalHelper::isHaveAbility($this->permission . 'delete')) ? '' : '<a href="' . route($this->route . '.destroy', $result->id) . '" class="btn btn-danger font-weight-bold btn-sm me-1 btn-delete"><i class="fa fa-trash"></i> Hapus</a>';

            $records[]      = array(
                'no'            => (string) $no,
                'nis'           => $result->nis,
                'nama'          => $result->nama,
                'alamat'        => $result->alamat,
                'asrama_nama'   => $result->asrama_nama,
                'total_paket'   => $result->total_paket,
                'action'        => $btn_detail . $btn_edit . $btn_delete
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

    public function show($id)
    {
        GlobalHelper::mustHaveAbility($this->permission . 'create');

        $data['record']         = MstSantri::findOrFail($id);

        $data['route']          = $this->route;
        $data['namespace']      = $this->namespace;
        $data['pagetitle']      = 'Detail ' . $this->pagetitle;;
        $data['permission']     = $this->permission;
        $data['information']    = $this->information;

        return view($this->namespace . 'detail', $data);
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

    public function store(SantriRequest $request)
    {
        GlobalHelper::mustHaveAbility($this->permission . 'create');
        try {
            DB::beginTransaction();
            $create                 = array();
            $create['nis']          = $request->nis;
            $create['nama']         = $request->nama;
            $create['alamat']       = $request->alamat;
            $create['asrama_id']    = $request->asrama_id;

            MstSantri::create($create);

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

        $data['record']         = MstSantri::findOrFail($id);

        return view($this->namespace . 'edit', $data);
    }

    public function update($id, SantriRequest $request)
    {
        GlobalHelper::mustHaveAbility($this->permission . 'update');
        try {
            DB::beginTransaction();
            $update                 = array();
            $update['nama']         = $request->nama;
            $update['alamat']       = $request->alamat;
            $update['asrama_id']    = $request->asrama_id;

            MstSantri::findOrFail($id)->update($update);

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
            MstSantri::find($id)->delete();
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

    public function cetak($id)
    {
        GlobalHelper::mustHaveAbility($this->permission . 'read');
        $data['record'] = MstSantri::findOrFail($id);
        $pdf            = Pdf::loadView($this->namespace . 'pdf', $data)->setPaper('A4');
        return $pdf->stream();
    }

    public function import(SantriImportRequest $request)
    {
        $miniValidator = function ($post, $rowNumber) {
            $validator = Validator::make($post, [
                'nis'           => 'required|unique:mst_santris,nis',
                'nama'          => 'required|max:100',
                'alamat'        => 'nullable|max:100',
                'asrama_id'     => 'required|exists:mst_asramas,id',
            ]);

            if ($validator->fails()) {
                $error     = '';
                $validator = $validator->errors()->messages();
                foreach ($validator as $value) {
                    $error .= ' - ' . $value[0] . ' pada line ' . $rowNumber . '<br>';
                }
                return $error;
            }
        };

        $sheets = FacadesExcel::toArray(new SantriImport, $request->file('file'));

        DB::beginTransaction();
        try {
            $products = [];
            foreach ($sheets[0] as $key => $row) {
                $product = array(
                    'nis'           => $row[0],
                    'nama'          => $row[1],
                    'alamat'        => $row[2],
                    'asrama_id'     => MstAsrama::where('nama', $row[3])->first()->id ?? null,
                );
                $rowNumber = 1 + ($key + 1); // +1 dari header

                $isInvalid = $miniValidator($product, $rowNumber);
                if ($isInvalid) throw new Exception($isInvalid);
                $products[] = $product;
            }

            foreach ($products as $product) {
                MstSantri::create([
                    'nis'       => $product['nis'],
                    'nama'      => $product['nama'],
                    'alamat'    => $product['alamat'],
                    'asrama_id' => $product['asrama_id'],
                ]);
            }

            DB::commit();

            // $datarow['status']  = 200;
            // $datarow['message'] = 'Data berhasil disimpan';
            $datarow               = ['success' => 'Data Berhasil Disimpan'];
        } catch (Throwable $th) {
            DB::rollBack();

            // $datarow['status']  = $th->getCode();
            // $datarow['message'] = $th->getMessage();
            $datarow               = ['error' => $th->getMessage()];
        } finally {
            //     return response()->json($datarow);
            return redirect()->route($this->route . '.index')
                ->with($datarow);
        }
    }

    public function export()
    {
        $filename       = 'data-santri-' . date('Y-m-d h:i:s') . '.xlsx';
        $records        = MstSantri::orderBy('nama')->get();
        return (new SantriExport($records))->download($filename, Excel::XLSX);
    }

    public function options(Request $request)
    {
        $totalRecord    = MstSantri::count();
        $limit          = request('limit', 30);
        $offset         = ($limit * request('page', '1')) - $limit;
        $search         = request('q', '');

        $results    = MstSantri::where(function ($q) use ($search) {
            $q->where('nis', 'like', '%' . $search . '%')
                ->orWhere('nama', 'like', '%' . $search . '%');
        })->when($request->asrama_id, fn($q) => $q->where('asrama_id', $request->asrama_id))
            ->orderBy('nama')
            ->limit($limit)
            ->offset($offset)
            ->get();

        $items = [];
        foreach ($results as $result) {
            $items[] = array(
                'id'    => $result->id,
                'text'  => "($result->nis) $result->nama"
            );
        }

        return response()->json([
            'items'         => $items,
            'total_count'   => $totalRecord
        ]);
    }
}
