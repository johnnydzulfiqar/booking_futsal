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
        $user = User::all();
        return view('admin.create', compact('user'));
    }
    public function store(Request $request)
    {
        $rules =
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'alamat' => ['required', 'string', 'max:255'],
                'type' => 'required',

            ];
        $this->validate($request, $rules);
        // $input = $request->all();
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'alamat' => $request['alamat'],
            'type' => $request['type'],
        ]);
        return redirect('/admin/index')->with('success', 'Data Berhasil Disimpan');
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
                'type' => 'required',
                'alamat' => ['required', 'string', 'max:255'],

            ];
        $this->validate($request, $rules);
        $input = $request->all();

        $admin->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'alamat' => $request['alamat'],
            'type' => $request['type'],
        ]);
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


    ///buat user saja
    public function edit2(User $user)
    {
        return view('user.create', compact(var_name: 'user'));
    }
    public function update2(User $user, Request $request)
    {
        $rules =
            [
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',

            ];
        $this->validate($request, $rules);
        $input = $request->all();
        $input = $request->except('type');
        $user->update($input);
        return redirect(to: '/booking/index')->with('success', 'Data Berhasil Diupdate');
    }
}
