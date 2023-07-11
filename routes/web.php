<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingAdminController;
use App\Http\Controllers\DashboardController;






/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);
// Auth::routes();
Route::get('/', [HomeController::class, 'jadwal'])->name('home');
Route::get('/home', [BookingController::class, 'index']);
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/booking/index', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/create', [BookingController::class, 'store']);
    Route::get('/booking/{booking}/edit', [BookingController::class, 'edit'])->name(name: 'booking.edit');
    Route::patch('/booking/{booking}', [BookingController::class, 'update'])->name(name: 'booking.update');
    Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name(name: 'booking.delete');
    Route::get('/booking/{booking}/show', [BookingController::class, 'show'])->name('booking.show');
    Route::get('/booking/jadwal', [BookingController::class, 'jadwal'])->name('jadwal.index');
    Route::get('/user/{user}/edit', [AdminController::class, 'edit2'])->name(name: 'user.edit');
    Route::patch('/user/{user}', [AdminController::class, 'update2'])->name(name: 'user.update');
    Route::get('/booking/filter', [BookingController::class, 'filter']);
    Route::get('/booking/{booking}/invoice', [BookingController::class, 'invoice']);
    Route::get('/booking/{booking}/invoice2', [BookingController::class, 'invoice2']);
    Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name(name: 'booking.delete');
});

Route::middleware(['auth', 'user-access:admin'])->group(function () {

    Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/create', [AdminController::class, 'store']);
    Route::get('/admin/{admin}/edit', [AdminController::class, 'edit'])->name(name: 'admin.edit');
    Route::patch('/admin/{admin}', [AdminController::class, 'update'])->name(name: 'admin.update');
    Route::delete('/admin/{admin}', [AdminController::class, 'destroy'])->name(name: 'admin.delete');
    Route::get('/lapangan/index', [LapanganController::class, 'index'])->name('lapangan.index');
    Route::get('/lapangan/create', [LapanganController::class, 'create'])->name('lapangan.create');
    Route::post('/lapangan/create', [LapanganController::class, 'store']);
    Route::get('/lapangan/{lapangan}/edit', [LapanganController::class, 'edit'])->name(name: 'lapangan.edit');
    Route::patch('/lapangan/{lapangan}', [LapanganController::class, 'update'])->name(name: 'lapangan.update');
    Route::delete('/lapangan/{lapangan}', [LapanganController::class, 'destroy'])->name(name: 'lapangan.delete');
    Route::get('/lapangan/{lapangan}/show', [LapanganController::class, 'show'])->name('lapangan.show');
    Route::get('/bookingadmin/index', [BookingAdminController::class, 'index'])->name('bookingadmin.index');
    Route::get('/bookingadmin/{booking}/edit', [BookingAdminController::class, 'edit'])->name(name: 'bookingadmin.edit');
    Route::patch('/bookingadmin/{booking}', [BookingAdminController::class, 'update'])->name(name: 'bookingadmin.update');
    Route::delete('/bookingadmin/{booking}', [BookingAdminController::class, 'destroy'])->name(name: 'bookingadmin.delete');
    Route::get('/bookingadmin/{booking}/show', [BookingAdminController::class, 'show'])->name('bookingadmin.show');
    Route::get('/bookingadmin/jadwal', [BookingAdminController::class, 'jadwal'])->name('jadwal.index');
    Route::get('/admin/filter', [BookingAdminController::class, 'filter']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/bookingadmin/{bookingadmin}/konfirmasi', [BookingAdminController::class, 'konfirmasi']);
    Route::get('/bookingadmin/{bookingadmin}/show', [BookingAdminController::class, 'show'])->name('booking.show');
    Route::get('/bookingadmin/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/bookingadmin/create', [BookingController::class, 'store']);
});
Route::middleware(['auth', 'user-access:pemilik'])->group(function () {
    Route::get('/pemilik/index', [BookingAdminController::class, 'index'])->name('pemilik.index');
    Route::get('/pemilik/dashboard', [DashboardController::class, 'index'])->name('dashboard.pemilik');
    Route::get('/pemilik/filter', [BookingAdminController::class, 'filter']);
});
