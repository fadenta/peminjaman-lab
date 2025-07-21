<?php

namespace App;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DaftarRuangController;
use App\Http\Controllers\DaftarPinjamController;
use App\Http\Controllers\DashboardRentController;
use App\Http\Controllers\DashboardRoomController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\TemporaryRentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('index', [
        'title' => "Home",
    ]);
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard/overview', function () {
        return view('/dashboard/overview/index', [
            'title' => "Dashboard Admin",
        ]);
    });

    // ✅ Letakkan di sini SEBELUM resource
    Route::get('/dashboard/rents/print', [DashboardRentController::class, 'print'])->name('rents.print');

    Route::middleware(['checkRole'])->group(function () {
        Route::get('/dashboard/temporaryRents', [TemporaryRentController::class, 'index']);
        Route::get('/dashboard/temporaryRents/{id}/acceptRents', [TemporaryRentController::class, 'acceptRents']);
        Route::get('/dashboard/temporaryRents/{id}/declineRents', [TemporaryRentController::class, 'declineRents']);

        Route::resource('dashboard/rents', DashboardRentController::class);
        Route::resource('dashboard/rooms', DashboardRoomController::class);
        Route::resource('dashboard/users', DashboardUserController::class);
        Route::resource('dashboard/admin', DashboardAdminController::class);

        Route::get('dashboard/rents/{id}/endTransaction', [DashboardRentController::class, 'endTransaction']);
        Route::get('dashboard/users/{id}/makeAdmin', [DashboardUserController::class, 'makeAdmin']);
        Route::get('dashboard/admin/{id}/removeAdmin', [DashboardAdminController::class, 'removeAdmin']);
    });

   // ... route lainnya ...
Route::get('/daftarruang', [DaftarRuangController::class, 'index']);
Route::get('/showruang/{room:code}', [DaftarRuangController::class, 'show']);

// Route untuk MENAMPILKAN halaman daftar pinjam
Route::get('/daftarpinjam', [DaftarPinjamController::class, 'index']); 

// TAMBAHKAN BARIS INI UNTUK MENERIMA DATA DARI FORM
Route::post('/daftarpinjam', [DashboardRentController::class, 'store']);

Route::post('/logout', [LoginController::class, 'logout']);
// ...
});
