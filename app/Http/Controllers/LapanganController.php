<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\Booking;
use App\Models\User;

// use PDF;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    public function index(Request $request)
    {
        $lapangan = Lapangan::all();
        return view('lapangan.index', compact('lapangan'));
    }
    public function create()
    {
        return view('lapangan.create');
    }
    public function store(Request $request)
    {
        $rules =
            [
                'nama' => 'required',
                'harga' => 'required',
                'status' => 'required',
            ];
        $this->validate($request, $rules);
        $input = $request->all();
        Lapangan::create($input);
        return redirect('/lapangan/index')->with('success', 'Data Berhasil Disimpan');
    }
    public function show($id)
    {
        $data = Lapangan::findOrfail($id);
        return view('lapangan.show', compact('data'));
    }
    public function edit(Lapangan $lapangan)
    {
        return view('lapangan.create', compact(var_name: 'lapangan'));
    }
    public function update(Lapangan $lapangan, Request $request)
    {
        $rules =
            [
                'nama' => 'required',
                'harga' => 'required',
                'status' => 'required',

            ];
        $this->validate($request, $rules);
        $input = $request->all();
        $lapangan->update($input);
        return redirect(to: '/lapangan/index')->with('success', 'Data Berhasil Diupdate');
    }
    public function destroy($id)
    {
        $lapangan = Lapangan::find($id);
        $lapangan->delete();
        return redirect('/lapangan/index')->with('success', 'Data Berhasil Dihapus');
    }
}
