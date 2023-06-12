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

class BookingAdminController extends Controller
{
    public function index(Request $request)
    {
        $booking = Booking::all();
        return view('bookingadmin.index', compact('booking'));
    }
    public function jadwal(Request $request)
    {
        $booking = Booking::all();
        $lapangan = Lapangan::all();
        return view('jadwal.index', compact('booking', 'lapangan'));
    }
    public function show($id)
    {
        $data = Booking::findOrfail($id);
        return view('bookingadmin.show', compact('data'));
    }
    public function edit(Booking $booking)
    {
        $lapangan = Lapangan::all();

        return view('bookingadmin.create', compact('booking', 'lapangan'));
    }
    public function update(Booking $booking, Request $request)
    {
        $rules =
            [
                // 'time_from' => 'required',
                // 'time_to' => 'required',
                'status' => 'required',
            ];
        $this->validate($request, $rules);

        $jam = Carbon::parse($request->time_from)->diffInHours(Carbon::parse($request->time_to));
        $booking->update([
            'status' => $request['status'],
        ]);
        return redirect('/bookingadmin/index');
    }
    public function destroy($id)
    {
        $data = Booking::find($id);
        $data->delete();
        return redirect('/bookingadmin/index')->with('success', 'Data Berhasil Dihapus');
    }
}
