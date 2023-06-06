<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\BookingController;





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

Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/booking/index', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/create', [BookingController::class, 'store']);
    Route::get('/booking/{booking}/edit', [BookingController::class, 'edit'])->name(name: 'booking.edit');
    Route::patch('/booking/{booking}', [BookingController::class, 'update'])->name(name: 'booking.update');
    Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name(name: 'booking.delete');
    Route::get('/booking/{booking}/show', [BookingController::class, 'show'])->name('booking.show');
});

Route::middleware(['auth', 'user-access:admin'])->group(function () {

    Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');
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
});
