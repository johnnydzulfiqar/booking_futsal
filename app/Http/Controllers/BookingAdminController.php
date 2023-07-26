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
    public function indexpemilik(Request $request)
    {
        $booking = Booking::all();
        $data = Booking::all()->first();
        return view('pemilik.index', compact('booking', 'data'));
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
        $data = Lapangan::all('harga', 'status')->first();
        return view('jadwal.index', compact('booking', 'lapangan', 'data'));
    }
    public function show($id)
    {
        $booking = Booking::findOrfail($id);
        $lapangan = Lapangan::all();
        $orderDate = Booking::findOrfail($id)->created_at;
        $paymentDue = (new \DateTime($orderDate))->modify('+1 hour')->format('Y-m-d H:i:s');
        return view('booking.show', compact('booking', 'lapangan', 'paymentDue'));
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
    public function konfirmasi(Booking $id, Request $request)
    {
        $data = Booking::find($request->id);
        $data->status = $request->status;
        $data->save();
        return redirect('/bookingadmin/index');
    }
}
