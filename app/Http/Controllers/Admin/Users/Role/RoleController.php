<?php

namespace App\Http\Controllers\Admin\Users\Role;

use App\Helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleRequest;
use App\Models\CoreMenu;
use App\Models\CorePrivilege;
use App\Models\CoreRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Throwable;

class RoleController extends Controller
{
	private $route              = 'admin.users.role';
	private $namespace          = 'pages.admin.users.role.';
	private $pagetitle          = 'Role';
	private $information		= 'Halaman ini digunakan untuk mengatur data role pengguna aplikasi.';
	private $table              = 'coreRole_table';
	private $permission         = 'role:';

	public function index()
	{
		GlobalHelper::mustHaveAbility($this->permission . 'read');
		$data['route']          = $this->route;
		$data['table']          = $this->table;
		$data['namespace']      = $this->namespace;
		$data['pagetitle']      = $this->pagetitle;
		$data['permission']     = $this->permission;
		$data['information']	= $this->information;

		return view($this->namespace . 'index', $data);
	}

	public function paginate(Request $request)
	{
		GlobalHelper::mustHaveAbility($this->permission . 'read');
		$post           = $request->input();
		$getData        = CoreRole::query();
		$where          = array();
		$join           = array();
		$leftjoin		= array();
		$total_records	= $getData->count();
		$total_filtered	= 0;
		$records		= array();
		$start          = intval($post['start']);
		$limit          = intval($post['length']);
		$awal           = $start;
		$columns		= array(
			1	=> 'core_roles.name',
			2	=> 'core_roles.description'
		);

		if (isset($post['search']['value'])) {
			$getData->where('name', 'LIKE', '%' . $post['search']['value'] . '%')
				->orWhere('description', 'LIKE', '%' . $post['search']['value'] . '%');
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
		$results		= $getData
			->limit($limit)
			->offset($awal)
			->get();

		$no				= 1 + $awal;
		foreach ($results as $result) {
			$btn_privilege	= (!GlobalHelper::isHaveAbility($this->permission . 'update')) ? '' : '<a href="' . route($this->route . '.privilege', $result->id) . '" class="btn btn-success font-weight-bold btn-sm me-1"><i class="fa fa-gear"></i> Perizinan</a>';
			$btn_edit		= (!GlobalHelper::isHaveAbility($this->permission . 'update')) ? '' : '<a href="' . route($this->route . '.edit', $result->id) . '" class="btn btn-warning font-weight-bold btn-sm me-1"><i class="fa fa-pencil"></i> Edit</a>';
			$btn_delete		= (!GlobalHelper::isHaveAbility($this->permission . 'delete')) ? '' : '<a href="' . route($this->route . '.destroy', $result->id) . '" class="btn btn-danger font-weight-bold btn-sm me-1 btn-delete"><i class="fa fa-trash"></i> Hapus</a>';

			$records[]		= array(
				'no'			=> (string) $no,
				'name'			=> $result->name,
				'description'	=> $result->description,
				'action'		=> $btn_privilege . $btn_edit . $btn_delete
			);
			$no++;
		}

		$datarow 		= array(
			'draw' 				=> $post['draw'],
			'recordsTotal'		=> $total_records,
			'recordsFiltered'	=> $total_filtered,
			'data'				=> $records
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
		$data['information']	= $this->information;

		return view($this->namespace . 'create', $data);
	}

	public function store(RoleRequest $request)
	{
		GlobalHelper::mustHaveAbility($this->permission . 'create');
		try {
			DB::beginTransaction();
			$create 					= array();
			$create['name']				= $request->name;
			$create['description']		= $request->description;

			CoreRole::create($create);

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
		$data['information']	= $this->information;

		$data['record']			= CoreRole::findOrFail($id);

		return view($this->namespace . 'edit', $data);
	}

	public function update($id, RoleRequest $request)
	{
		GlobalHelper::mustHaveAbility($this->permission . 'update');
		try {
			DB::beginTransaction();
			$update 					= array();
			$update['name']				= $request->name;
			$update['description']		= $request->description;

			CoreRole::findOrFail($id)->update($update);

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
			CoreRole::find($id)->delete();
			DB::commit();

			$datarow['status']	= 200;
			$datarow['message']	= Lang::get('message.success_delete_data');
		} catch (Throwable $th) {

			DB::rollBack();

			$datarow['status']	= $th->getCode();
			$datarow['message']	= $th->getMessage();
		} finally {
			return response()->json($datarow);
		}
	}

	public function all()
	{
		$totalRecord	= CoreRole::count();
		$limit			= request('limit', 30);
		$offset			= ($limit * request('page', '1')) - $limit;
		$search			= request('q', '');

		$results	= CoreRole::where('name', 'like', '%' . $search . '%')
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
			'items' 		=> $items,
			'total_count' 	=> $totalRecord
		]);
	}

	public function privilege($id)
	{
		$data['route']          = $this->route;
		$data['pagetitle']      = 'Perizinan ' . $this->pagetitle;
		$data['table']          = $this->table;
		$data['permission']     = $this->permission;
		$data['subheaders']     = ['Index' => route($this->route . '.index')];
		$data['information']    = $this->information;

		$privileges             = CorePrivilege::where('role_id', $id)->get();
		$privileges             = Arr::pluck($privileges, 'ability_id');
		$data['role']           = CoreRole::findOrFail($id);
		$data['privileges']     = $privileges;
		$data['menus']          = CoreMenu::with('allChilds', 'abilities')->childless()->where('is_show', true)->orderBy('order')->get();

		return view($this->namespace . 'privilege', $data);
	}

	public function storePrivilege($id, Request $request)
	{
		DB::beginTransaction();
		try {
			CorePrivilege::where('role_id', $id)->delete();

			$privileges     = [];
			if ($request->privileges) {
				foreach ($request->privileges as $privilege) {
					$privileges[] = array(
						'ability_id'    => $privilege,
						'role_id'       => $id,
						'created_at'    => Carbon::now()
					);
				}
			}

			if (!empty($privileges)) {
				CorePrivilege::insert($privileges);
			}

			DB::commit();

			return redirect()->route($this->route . '.privilege', [$id])
				->with(['success' => Lang::get('message.success_save_data')]);
		} catch (Throwable $th) {
			DB::rollBack();

			return redirect()->route($this->route . '.privilege', [$id])
				->with(['error' => $th->getMessage()]);
		}
	}
}
