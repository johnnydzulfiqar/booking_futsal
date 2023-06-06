<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $data['user'] = User::all();
        return view('admin.index', $data);
    }
    public function create()
    {
        return view('admin.create');
    }
    public function edit(User $admin)
    {
        return view('admin.create', compact(var_name: 'admin'));
    }
    public function update(User $admin, Request $request)
    {
        $rules =
            [
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
                // 'foto_produk' => 'required|mimes:jpg,png|max:1024',
                'type' => 'required',
            ];
        $this->validate($request, $rules);
        $input = $request->all();

        // if ($request->hasFile('foto_produk')) {
        //     $fileName = $request->foto_produk->getClientOriginalName();

        //     $request->foto_produk->storeAs('admin', $fileName);
        //     $input['foto_produk'] = $fileName;
        // }
        $admin->update($input);
        return redirect(to: '/admin/index')->with('success', 'Data Berhasil Diupdate');
    }
    public function destroy($id)
    {
        $admin = User::find($id);
        // if ($admin->type() == '1') {
        //     abort(401, 'Admin cannot delete admins!');
        // }
        $admin->delete();
        return redirect('/admin/index')->with('success', 'Data Berhasil Dihapus');
    }
}
