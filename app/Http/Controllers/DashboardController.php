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

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $bookingpending = Booking::where('status', '=', 'Belum Bayar')->count();
        $booking = Booking::where('status', '=', 'Masuk Jadwal')
            ->orWhere('status', 'Selesai')
            ->count();
        $income = Booking::where('status', 'Masuk Jadwal')
            ->orWhere('status', 'Selesai')
            ->sum('total_harga');

        return view('dashboard.index', compact('userCount', 'bookingpending', 'booking', 'income'));
    }
    public function index_user()
    {
        $user_id = Auth::user()->id;
        $data = Booking::where('user_id', '=',  $user_id)
            // ->orWhere('status', 'Selesai')
            ->count();
        return view('dashboard.index_user', compact('data'));
    }
}
