<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = Role::latest()->get();
        return view('/admin/settings/permission/show', compact('data'));
    }

    public function create()
    {
        $permission = Permission::get();
        return view('/admin/settings/permission/add', compact('permission'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return back()->with('success', 'Tambah Roler Berhasil !');
    }

    public function destroy($id)
    {
        try {
            $permission = Role::findOrFail($id);
            $permission->delete();
            return back()->with('success', 'Hapus Role Berhasil!');
        } catch (\Exception $e) {
            return back()->with('failed', 'Hapus Role Gagal!');
        }
    }
}
