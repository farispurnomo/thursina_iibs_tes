<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileRequest;
use App\Models\CoreUser;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProfileController extends Controller
{
    private $route              = 'admin.profile';
    private $namespace          = 'pages.admin.profile.';
    private $pagetitle          = 'Profile';
    private $information        = 'Halaman ini digunakan untuk mengubah detail profil';

    public function index()
    {
        $data['route']          = $this->route;
        $data['namespace']      = $this->namespace;
        $data['pagetitle']      = $this->pagetitle;
        $data['information']    = $this->information;

        $data['record']         = Auth::user();

        return view($this->namespace . 'index', $data);
    }

    public function store(ProfileRequest $request)
    {
        try {
            $id     = Auth::user()->id;

            $prefix = Str::random(16);
            if ($request->hasFile('image')) {
                $generated_new_name = $prefix . '.' . $request->image->getClientOriginalExtension();
                $image_name         = '/uploads/users/' . $generated_new_name;
                Storage::putFileAs('uploads/users', $request->file('image'), $generated_new_name);
            }

            DB::beginTransaction();

            $update                     = array();
            $update['name']             = $request->name;
            $update['phone']            = $request->phone;
            $update['address']          = $request->address;

            if ($request->password) {
                $update['password']     = bcrypt($request->password);
            }

            if (isset($image_name)) {
                $update['image']        = $image_name;
            }

            CoreUser::findOrFail($id)->update($update);

            DB::commit();

            return redirect()->route($this->route . '.index')->with('success', Lang::get('message.success_update_data'));
        } catch (Throwable $th) {
            DB::rollBack();

            return redirect()->route($this->route . '.index', $id)->withInput()->with('error', $th->getMessage());
        }
    }
}
