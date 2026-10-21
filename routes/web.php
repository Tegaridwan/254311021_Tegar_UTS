<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\penjualController;
use App\Http\Controllers\TambahUlasanController;
use App\Models\penjual;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResponController;
use App\Http\Controllers\LaporanUlasanController;

// 1. Route Beranda / Dashboard Pembeli
Route::get('/', function () {
    $penjualList = penjual::all();
    return view('dashboard', compact('penjualList'));
})->name('dashboard');

// 2. Auth Routes Guest (Login & Register khusus Penjual)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// 3. Auth Routes (Khusus Penjual setelah Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    
    // Halaman Utama / Dashboard Penjual
    Route::get('/homePenjual', function () {
        $penjual = penjual::find(Auth::id());
        return view('homePenjual', compact('penjual'));
    })->name('homePenjual');

    // Halaman Form Edit Data Penjual
    Route::get('/penjual/edit', function () {
        $penjual = penjual::find(Auth::id());
        return view('editPenjual', compact('penjual'));
    })->name('penjual.edit');

    // Halaman Lihat Ulasan khusus Penjual
    Route::get('/penjual/ulasan', function () {
        $penjual = penjual::find(Auth::id());
        return view('ViewUlasan', compact('penjual'));
    })->name('penjual.ulasan');

    Route::delete('/penjual/ulasan/{id}/hapus', [TambahUlasanController::class, 'destroy'])->name('ulasan.destroy');

    // Proses Simpan / Update Data Penjual
    Route::post('simpan-penjual', [penjualController::class, 'store'])->name('penjual.store');
});

// 4. Public Routes (Akses Umum Pembeli)
Route::get('/penjual/{id}', function ($id) {
    $penjual = penjual::findOrFail($id);
    return view('detail', compact('penjual'));
})->name('penjual.detail');

Route::get('/ulasan/{id}', function ($id) {
    $penjual = penjual::findOrFail($id);
    return view('formulasan', compact('penjual'));
})->name('ulasan.create');

//laporan ulasan
Route::post('/laporan-ulasan', [LaporanUlasanController::class, 'store'])->name('laporan-ulasan.store');


// 5. Routes untuk Respon Penjual
Route::post('/respon', [ResponController::class, 'store'])->name('respon.store');
Route::get('/respon/{id}/edit', [ResponController::class, 'edit'])->name('respon.edit');
Route::put('/respon/{id}', [ResponController::class, 'update'])->name('respon.update');
Route::delete('/respon/{id}', [ResponController::class, 'destroy'])->name('respon.destroy');
Route::post('/ulasan', [TambahUlasanController::class, 'store'])->name('ulasan.store');