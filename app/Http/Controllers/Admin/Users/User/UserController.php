<?php

namespace App\Http\Controllers\Admin\Users\User;

use App\Exports\UserExport;
use App\Helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Models\CoreRole;
use App\Models\CoreUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;
use Throwable;

class UserController extends Controller
{
    private $route              = 'admin.users.user';
    private $namespace          = 'pages.admin.users.user.';
    private $pagetitle          = 'Pengguna';
    private $information        = 'Halaman ini digunakan untuk mengatur data pengguna aplikasi.';
    private $table              = 'coreUser_table';
    private $permission         = 'user:';

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
        $getData        = CoreUser::select(
            'core_users.*',
            'core_roles.name AS role_name'
        );
        $where          = array();
        $join           = array();
        $leftjoin       = array(
            ['core_roles', 'core_roles.id', 'core_users.role_id']
        );
        $total_records  = $getData->count();
        $total_filtered = 0;
        $records        = array();
        $start          = intval($post['start']);
        $limit          = intval($post['length']);
        $awal           = $start;
        $columns        = array(
            1   => 'core_users.name',
            2   => 'core_roles.name',
            3   => 'core_users.phone'
        );

        if (isset($post['search']['value'])) {
            $getData->where('core_users.name', 'LIKE', '%' . $post['search']['value'] . '%')
                ->orWhere('core_users.email', 'LIKE', '%' . $post['search']['value'] . '%')
                ->orWhere('core_roles.name', 'LIKE', '%' . $post['search']['value'] . '%');
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

        $no                 = 1 + $awal;
        foreach ($results as $result) {
            $btn_edit       = (!GlobalHelper::isHaveAbility($this->permission . 'update')) ? '' : '<a href="' . route($this->route . '.edit', $result->id) . '" class="btn btn-warning font-weight-bold btn-sm me-1"><i class="fa fa-pencil"></i> Edit</a>';
            $btn_delete     = (!GlobalHelper::isHaveAbility($this->permission . 'delete')) ? '' : '<a href="' . route($this->route . '.destroy', $result->id) . '" class="btn btn-danger font-weight-bold btn-sm me-1 btn-delete"><i class="fa fa-trash"></i> Hapus</a>';

            $user           = '
                <div class="row">
                    <div class="col-auto text-center">
                        <img draggable="false" class="img-fluid rounded-circle img-thumbnail" style="height: 48px; width: 48px" src="' . $result->url_image . '"/>
                    </div>
                    <div class="col-auto">
                        <div>' . $result->name . '</div>
                        <div class="small text-muted">' . $result->email . '</div>
                    </div>
                <div>';

            $records[]      = array(
                'no'            => (string) $no,
                'user'          => $user,
                'phone'         => $result->phone,
                'role'          => $result->role_name,
                'action'        => $btn_edit . $btn_delete
            );
            $no++;
        }

        $datarow         = array(
            'draw'                  => $post['draw'],
            'recordsTotal'          => $total_records,
            'recordsFiltered'       => $total_filtered,
            'data'                  => $records
        );

        return response()->json($datarow);
    }

    public function create(Request $request)
    {
        GlobalHelper::mustHaveAbility($this->permission . 'create');

        $data['route']          = $this->route;
        $data['namespace']      = $this->namespace;
        $data['pagetitle']      = 'Tambah ' . $this->pagetitle;
        $data['permission']     = $this->permission;
        $data['information']    = $this->information;
        $data['role']            = null;

        if ($v = $request->old('role_id')) {
            $data['role']        = CoreRole::find($v);
        }

        return view($this->namespace . 'create', $data);
    }

    public function store(UserRequest $request)
    {
        GlobalHelper::mustHaveAbility($this->permission . 'create');

        try {
            $image_name             = null;

            $prefix                 = Str::random(16);
            if ($request->hasFile('image')) {
                $generated_new_name = $prefix . '.' . $request->image->getClientOriginalExtension();
                $image_name         = '/uploads/users/' . $generated_new_name;
                Storage::putFileAs('uploads/users', $request->file('image'), $generated_new_name);
            }

            DB::beginTransaction();

            $create                     = array();
            $create['name']             = $request->name;
            $create['email']            = $request->email;
            $create['password']         = bcrypt($request->password);
            $create['role_id']          = $request->role_id;
            $create['image']            = $image_name;
            $create['phone']            = $request->phone;
            $create['address']          = $request->address;

            CoreUser::create($create);

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

        $data['record']            = CoreUser::findOrFail($id);

        return view($this->namespace . 'edit', $data);
    }

    public function update($id, UserRequest $request)
    {
        GlobalHelper::mustHaveAbility($this->permission . 'update');

        try {
            $image_name             = null;
            $prefix                 = Str::random(16);
            if ($request->hasFile('image')) {
                $generated_new_name = $prefix . '.' . $request->image->getClientOriginalExtension();
                $image_name         = '/uploads/users/' . $generated_new_name;
                Storage::putFileAs('uploads/users', $request->file('image'), $generated_new_name);
            }

            DB::beginTransaction();

            $update                     = array();
            $update['name']             = $request->name;
            $update['role_id']          = $request->role_id;
            $update['phone']            = $request->phone;
            $update['address']          = $request->address;

            if ($request->password) {
                $update['password']     = bcrypt($request->password);
            }

            if ($image_name) {
                $update['image']        = $image_name;
            }

            CoreUser::findOrFail($id)->update($update);

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
            CoreUser::find($id)->delete();
            DB::commit();

            $datarow['status']    = 200;
            $datarow['message']    = Lang::get('message.success_delete_data');
        } catch (Throwable $th) {

            DB::rollBack();

            $datarow['status']    = $th->getCode();
            $datarow['message']    = $th->getMessage();
        } finally {
            return response()->json($datarow);
        }
    }

    public function export()
    {
        $filename       = 'data-user-' . date('Y-m-d h:i:s') . '.xlsx';
        $records        = CoreUser::orderBy('name')->get();
        return (new UserExport($records))->download($filename, Excel::XLSX);
    }

    public function all(Request $request)
    {
        $totalRecord    = CoreUser::count();
        $limit          = request('limit', 30);
        $offset         = ($limit * request('page', '1')) - $limit;
        $search         = request('q', '');

        $results    = CoreUser::where('name', 'like', '%' . $search . '%')
            ->when($request->role_id, fn($q) => $q->where('role_id', $request->role_id))
            ->orderBy('name')
            ->limit($limit)
            ->offset($offset)
            ->get();

        $items = [];
        foreach ($results as $result) {
            $items[] = array(
                'id'    => $result->id,
                'text'  => $result->name
            );
        }

        return response()->json([
            'items'         => $items,
            'total_count'   => $totalRecord
        ]);
    }
}
