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
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use function PHPUnit\Framework\isNull;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $booking = Booking::all();
        return view('booking.index', compact('booking'));
    }
    public function jadwal(Request $request)
    {
        $booking = Booking::all();
        $lapangan = Lapangan::all();
        return view('jadwal.index', compact('booking', 'lapangan'));
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

                'time_from' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $now = Carbon::parse($value . ':00:00');
                        if ($now->lt(Carbon::parse($now)->setHours(7))) {
                            $fail('Jam Mulai tidak boleh kurang dari 07:00');
                        }
                        $today = Booking::query()
                            ->where('time_from', 'like', $now->format('Y-m-d') . '%')
                            ->get();
                        foreach ($today as $book) {
                            if ($now->between(Carbon::parse($book->time_from), Carbon::parse($book->time_to))) {
                                $fail('Waktu telah di booking');
                            }
                        }
                    }
                ],
                'time_to' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $now = Carbon::parse($value . ':00:00');
                        if ($now->gte(Carbon::parse($now)->setHours(1)) && $now->lt(Carbon::parse($now)->setHours(7))) {
                            $fail('Jam Selesai tidak boleh lebih dari 24:00');
                        }
                        $today = Booking::query()
                            ->where('time_from', 'like', $now->format('Y-m-d') . '%')
                            ->get();
                        foreach ($today as $book) {
                            if ($now->between(Carbon::parse($book->time_from), Carbon::parse($book->time_to))) {
                                $fail('Waktu telah di booking');
                            }
                        }
                    }
                ]
                // 'bukti' => 'mimes:jpg,png|max:1024',
            ];
        $this->validate($request, $rules);
        // if ($request->hasFile('bukti')) {
        //     $fileName = $request->bukti->getClientOriginalName();
        //     $request->bukti->storeAs('bukti', $fileName);
        //     $input['bukti'] = $fileName;
        // }
        $time_from = Carbon::parse($request->time_from . ':00:00');
        $time_to = Carbon::parse($request->time_to . ':00:00');
        $jam = $time_from->diffInHours($time_to,false);
        $is_same_day = $time_from->diffInDays($time_to) === 0;
        if ($jam < 1) {
            throw ValidationException::withMessages([
                'time_from' => 'Jam Mulai lebih besar dari jam selesai',
                'time_to' => 'Jam Selesai lebih kecil dari jam mulai',
            ]);
        }
        if (! $is_same_day) {
            throw ValidationException::withMessages([
                'time_to' => 'Jam Selesai harus di hari yang sama',
            ]);
        }
        $total = 0;
        $lapangan = Lapangan::findOrFail($request['lapangan_id']);
        $jam_start = (int) $time_from->format('G');
        $jam_end = (int) $time_to->format('G');
        $jam_end = $jam_end === 0 ? 24 : $jam_end;
        if ($jam_end === 0) {
            $time_to->subMinute();
        }
        $today = Booking::query()
            ->where('time_from', 'like', $time_from->format('Y-m-d') . '%')
            ->get();
        for ($i = $jam_start; $i < $jam_end; $i++) {
            $check = Carbon::parse($time_from)->setHours($i);
            foreach ($today as $book) {
                if ($check->between(Carbon::parse($book->time_from), Carbon::parse($book->time_to))) {
                    throw ValidationException::withMessages([
                        'time_from' => 'Waktu telah di booking',
                        'time_to' => 'Waktu telah di booking',
                    ]);
                }
            }
            if ($i < 15) {
                $total += $lapangan->harga;
            } else if ($i >= 15 && $i < 18) {
                $total += ($lapangan->harga + 50000);
            } else {
                $total += ($lapangan->harga + 100000);
            }
        }

        $data = Booking::create(
            [
                'lapangan_id' => $request['lapangan_id'],
                'time_from' => $request['time_from'],
                'time_to' => $request['time_to'],
                'status' => 'Belum Bayar DP',
                'bukti' => null,
                'user_id' => Auth::id(),
                'jam' => $jam,
                'total_harga' => $total,
            ]

        );
        return redirect('/booking/index')->with('success', 'Data Berhasil Disimpan');
    }
    public function show($id)
    {
        $booking = Booking::findOrfail($id);
        $lapangan = Lapangan::all();
        return view('booking.show', compact('booking', 'lapangan'));
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
        // $input = $request->all();
        // $input = $request->except('user_id');
        if ($request->hasFile('bukti')) {
            $fileName = $request->bukti->getClientOriginalName();
            $request->bukti->storeAs('img', $fileName);
            // Storage::disk('public')->put($fileName, $request->file('bukti'));
            $input = $fileName;
        }
        $booking->update([
            'bukti' => $input,
        ]);
        return redirect('/booking/index');
    }
    public function destroy($id)
    {
        $data = Booking::find($id);
        $data->delete();
        return redirect('/booking/index')->with('success', 'Data Berhasil Dihapus');
    }
}
