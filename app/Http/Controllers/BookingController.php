<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessBooking;
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
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'verified']);
    // }
    public function index(Request $request)
    {
        $booking = Booking::all();
        $data = Booking::all()->first();
        return view('booking.index', compact('booking', 'data'));
    }
    public function filter(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        if (empty($start_date && $end_date)) {
            $booking = Booking::all();
            $data = Booking::all()->first();
            return view('booking.index', compact('booking', 'data'));
        } else {
            $booking = Booking::whereBetween('time_from', [$start_date, $end_date])
                ->get();
            $data = Booking::all()->first();
            return view('booking.index', compact('booking', 'data'));
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
    public function create()
    {
        $lapangan = Lapangan::all();
        $data = Lapangan::all('harga')->first();
        return view('booking.create', compact('lapangan', 'data'));
    }
    public function store(Request $request)
    {
        $rules =
            [

                'time_from' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $now = Carbon::parse($value . ':00')->locale('id');
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
                        $now = Carbon::parse($value . ':00')->locale('id');
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
        $time_from = Carbon::parse($request->time_from . ':00');
        $time_to = Carbon::parse($request->time_to . ':00');
        $jam = $time_from->diffInHours($time_to, false);
        $is_same_day = $time_from->diffInDays($time_to) === 0;
        if ($jam < 1) {
            throw ValidationException::withMessages([
                'time_from' => 'Jam Mulai lebih besar dari jam selesai',
                'time_to' => 'Jam Selesai lebih kecil dari jam mulai',
            ]);
        }
        if (!$is_same_day) {
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
        // dd([
        //     'lapangan_id' => $request['lapangan_id'],
        //     'time_from' => $request['time_from'],
        //     'time_to' => $request['time_to'],
        //     'status' => 'Belum Bayar DP',
        //     'bukti' => null,
        //     'user_id' => Auth::id(),
        //     'jam' => $jam,
        //     'total_harga' => $total,
        // ]);
        if (Auth::user()->type == 1) {
            $data = Booking::create(
                [
                    'lapangan_id' => $request['lapangan_id'],
                    'time_from' => $request['time_from'],
                    'time_to' => $request['time_to'],
                    'status' => 'Masuk Jadwal',
                    'bukti' => 'Lunas',
                    'user_id' => Auth::id(),
                    'jam' => $jam,
                    'total_harga' => $total,
                    'pembayaraan' => 'Lunas',


                ]
            );
        } else {
            $data = Booking::create(
                [
                    'lapangan_id' => $request['lapangan_id'],
                    'time_from' => $request['time_from'],
                    'time_to' => $request['time_to'],
                    'status' => 'Belum Bayar',
                    'bukti' => null,
                    'user_id' => Auth::id(),
                    'jam' => $jam,
                    'total_harga' => $total,
                    'pembayaraan' => $request['pembayaraan'],
                ]
            );
        }

        // ProcessBooking::dispatch($data)
        //     ->delay(now()->addHour());
        ProcessBooking::dispatch($data)
            ->delay(now()->addMinutes(2));
        // ProcessBooking::dispatch($data)
        //     ->delay($time_to > now());
        if (Auth::user()->type == 1) {
            return redirect('/bookingadmin/index')->with('success', 'Data Berhasil Disimpan');
        } else {
            return redirect('/booking/index')->with('success', 'Data Berhasil Disimpan');
        }
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
        $data = Lapangan::all('harga')->first();
        return view('booking.create', compact('booking', 'lapangan', 'data'));
    }
    public function update(Booking $booking, Request $request)
    {
        $rules =
            [

                'time_from' => [
                    'required',
                    function ($attribute, $value, $fail) use ($booking) {
                        $now = Carbon::parse($value . ':00');
                        if ($now->lt(Carbon::parse($now)->setHours(7))) {
                            $fail('Jam Mulai tidak boleh kurang dari 07:00');
                        }
                        $today = Booking::query()
                            ->whereNot('id', $booking->id)
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
                    function ($attribute, $value, $fail) use ($booking) {
                        $now = Carbon::parse($value . ':00');
                        if ($now->gte(Carbon::parse($now)->setHours(1)) && $now->lt(Carbon::parse($now)->setHours(7))) {
                            $fail('Jam Selesai tidak boleh lebih dari 24:00');
                        }
                        $today = Booking::query()
                            ->whereNot('id', $booking->id)
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
        $time_from = Carbon::parse($request->time_from . ':00');
        $time_to = Carbon::parse($request->time_to . ':00');
        $jam = $time_from->diffInHours($time_to, false);
        $is_same_day = $time_from->diffInDays($time_to) === 0;
        if ($jam < 1) {
            throw ValidationException::withMessages([
                'time_from' => 'Jam Mulai lebih besar dari jam selesai',
                'time_to' => 'Jam Selesai lebih kecil dari jam mulai',
            ]);
        }
        if (!$is_same_day) {
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
            ->whereNot('id', $booking->id)
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

        $input = $request->all();
        $input = $request->except('user_id');
        if ($request->hasFile('bukti')) {
            $fileName = $request->bukti->getClientOriginalName();
            $request->bukti->storeAs('img', $fileName);
            // Storage::disk('public')->put($fileName, $request->file('bukti'));
            $input['bukti'] = $fileName;

            $test = ['user_id' => Auth::id()];
            // dd($test);
            if ($test == ['user_id' => Auth::id()]) {
                $booking->update([
                    'lapangan_id' => $request['lapangan_id'],
                    'time_from' => $request['time_from'],
                    'time_to' => $request['time_to'],
                    'status' => 'Pending',
                    'bukti' => $input['bukti'] = $fileName,
                    // 'user_id' => Auth::id(),
                    'jam' => $jam,
                    'total_harga' => $total,
                    'pembayaraan' => $request['pembayaraan'],
                    // $input

                ]);
            } else {
                $booking->update([
                    'status' => $request['time_to'],
                ]);
            }
        } else {
            $booking->update([
                'lapangan_id' => $request['lapangan_id'],
                'time_from' => $request['time_from'],
                'time_to' => $request['time_to'],
                'status' => 'Pending',
                'jam' => $jam,
                'total_harga' => $total,
                'pembayaraan' => $request['pembayaraan'],
            ]);
        }

        return redirect('/booking/index');
    }
    public function destroy($id)
    {
        $data = Booking::find($id);
        $data->delete();
        return redirect('/booking/index')->with('success', 'Data Berhasil Dihapus');
    }
    public function invoice($id)
    {
        $data = Booking::find($id);
        $pdf = PDF::loadview('booking.invoice', ['data' => $data]);
        return $pdf->download('invoice.pdf');
    }
    public function invoice2($id)
    {
        $data = Booking::find($id);
        $orderDate = date('Y-m-d H:i:s');
        $paymentDue = (new \DateTime($orderDate))->modify('+1 hour')->format('Y-m-d H:i:s');
        return view('booking.invoice2', compact('data'));
    }
    public function konfirmasi(Booking $id, Request $request)
    {
        $data = Booking::find($request->id);
        $data->status = $request->status;
        $data->save();
        return redirect('/booking/index');
    }
}
