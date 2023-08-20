<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = User::latest()->get();
        return view('/admin/settings/user/show', compact('data'));
    }

    public function create()
    {
        $role = Role::pluck('name', 'name')->all();
        return view('/admin/settings/user/add', compact('role'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return back()->with('success', 'Tambah User Berhasil !');
    }

    public function edit($id)
    {
        $data = User::findOrFail($id);
        $role = Role::all();
        return view('/admin/settings/user/edit', compact('data', 'role'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->roles()->sync([$request->input('roles')]);
        return back()->with('success', 'Update User Berhasil !');
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return back()->with('success', 'Hapus User Berhasil!');
        } catch (\Exception $e) {
            return back()->with('failed', 'Hapus User Gagal!');
        }
    }
}
