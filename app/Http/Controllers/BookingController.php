<?php

namespace App\Http\Controllers;


use App\Models\Lapangan;
use App\Models\Booking;
use App\Models\User;

use PDF;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class BookingController extends Controller
{
    public function index(Request $request)
    {
        $booking = Booking::all();
        return view('booking.index', compact('booking'));
    }
    public function create()
    {
        $lapangan = Lapangan::all();
        return view('booking.create', compact('lapangan'));
    }
    public function store(Request $request)
    {
        $rules =
            [

                'time_from' => 'required',
                'time_to' => 'required',
                // 'bukti' => 'mimes:jpg,png|max:1024',
            ];
        $this->validate($request, $rules);
        // if ($request->hasFile('bukti')) {
        //     $fileName = $request->bukti->getClientOriginalName();
        //     $request->bukti->storeAs('bukti', $fileName);
        //     $input['bukti'] = $fileName;
        // }
        $data = Booking::create(
            [
                'lapangan_id' => $request['lapangan_id'],
                'time_from' => $request['time_from'],
                'time_to' => $request['time_to'],
                'status' => 'Belum Bayar DP',
                'bukti' => null,
                'user_id' => Auth::id(),
            ]
        );
        dd($data);
        return redirect('/booking/index')->with('success', 'Data Berhasil Disimpan');
    }
    public function show($id)
    {
        $data = Booking::findOrfail($id);
        return view('booking.show', compact('data'));
    }
    public function edit(Booking $booking)
    {
        $lapangan = Lapangan::all();
        return view('booking.create', compact('booking', 'lapangan'));
    }
    public function update(Booking $booking, Request $request)
    {
        $rules =
            [
                // 'time_from' => 'required',
                // 'time_to' => 'required',
                'bukti' => 'mimes:jpg,png|max:1024',
            ];
        $this->validate($request, $rules);
        if ($request->hasFile('bukti')) {
            $fileName = $request->bukti->getClientOriginalName();
            $request->bukti->storeAs('bukti', $fileName);
            $input['bukti'] = $fileName;
        }
        $input = Booking::find($request->id);
        $input->bukti = $request->bukti;
        $input->save();
        // // $stok = Admin::find($request->admin_id);
        // $stok->stok = $request->stok;
        // $stok->save();
        dd($booking);
        return redirect('/booking/index');
    }
    public function destroy($id)
    {
        $data = Booking::find($id);
        $data->delete();
        return redirect('/booking/index')->with('success', 'Data Berhasil Dihapus');
    }
}
