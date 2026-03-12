<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UlasanController;
use App\Http\Middleware\PreventBackHistory;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth', PreventBackHistory::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/tambah-petugas', [DashboardController::class, 'storePetugas'])->name('petugas.store');
    Route::delete('/hapus-petugas/{id}', [DashboardController::class, 'destroyPetugas'])->name('petugas.destroy');
    Route::middleware('can:kelola-barang')->group(function () {
        
        Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
        Route::get('/laporan', [PeminjamanController::class, 'indexLaporan'])->name('laporan.index');
        Route::post('/peminjaman/{id}/terima', [PeminjamanController::class, 'terimaPengembalian'])->name('peminjaman.terima');
        Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolakPengembalian'])->name('peminjaman.tolak');
        Route::get('/laporan/cetak', [PeminjamanController::class, 'cetakLaporan'])->name('laporan.cetak');
    });

    Route::get('/peminjaman/riwayat', [PeminjamanController::class, 'index'])->name('peminjaman.riwayat');

    Route::middleware('can:meminjam')->group(function () {
        Route::post('/peminjaman/{buku_id}', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::post('/ulasan/{buku_id}', [UlasanController::class, 'store'])->name('ulasan.store');
        Route::post('/peminjaman/{id}/ajukan-kembali', [PeminjamanController::class, 'ajukanKembali'])->name('peminjaman.ajukan');
    });

});
