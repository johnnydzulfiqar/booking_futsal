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
        $data = Booking::all()->first();
        return view('bookingadmin.index', compact('booking', 'data'));
    }
    public function filter(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        if (empty($start_date && $end_date)) {
            $booking = Booking::all();
            $data = Booking::all()->first();
            return view('bookingadmin.index', compact('booking', 'data'));
        } else {
            $booking = Booking::whereBetween('time_from', [$start_date, $end_date])
                ->get();
            $data = Booking::all()->first();
            return view('bookingadmin.index', compact('booking', 'data'));
        }
    }
    public function jadwal(Request $request)
    {
        $booking = Booking::where('status', 'Masuk Jadwal')
            ->orWhere('status', 'Selesai')
            ->get();
        $lapangan = Lapangan::all();
        $data = Lapangan::all('harga')->first();
        return view('jadwal.index', compact('booking', 'lapangan', 'data'));
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
