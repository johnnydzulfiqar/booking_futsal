<?php

namespace App\Http\Controllers;


use App\Models\Lapangan;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isNull;

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
        $jam = Carbon::parse($request->time_from)->diffInHours(Carbon::parse($request->time_to));


        $data = Booking::create(
            [
                'lapangan_id' => $request['lapangan_id'],
                'time_from' => $request['time_from'],
                'time_to' => $request['time_to'],
                'status' => 'Belum Bayar DP',
                'bukti' => null,
                'user_id' => Auth::id(),
                'jam' =>  $jam,
                'total_harga' => $jam * $request['harga'],
            ]

        );
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
        $input = $request->all();
        $input = $request->except('user_id');
        if ($request->hasFile('bukti')) {
            $fileName = $request->bukti->getClientOriginalName();
            $request->bukti->storeAs('img', $fileName);
            // Storage::disk('public')->put($fileName, $request->file('bukti'));
            $input['bukti'] = $fileName;
        }

        $booking->update($input);
        return redirect('/booking/index');
    }
    public function destroy($id)
    {
        $data = Booking::find($id);
        $data->delete();
        return redirect('/booking/index')->with('success', 'Data Berhasil Dihapus');
    }
}
