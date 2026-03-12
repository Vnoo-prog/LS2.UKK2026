<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UlasanController;
use App\Http\Middleware\PreventBackHistory; // <-- Panggil Middleware Anti-Back di sini

// Halaman Utama otomatis diarahkan ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// =======================================================
// ROUTE GUEST (HANYA BISA DIAKSES JIKA BELUM LOGIN)
// =======================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// =======================================================
// ROUTE AUTH (HARUS LOGIN) + PROTEKSI ANTI-CACHE (ANTI-BACK)
// =======================================================
// PERBAIKAN: Gunakan class PreventBackHistory::class agar tidak error di Laravel 12
Route::middleware(['auth', PreventBackHistory::class])->group(function () {

    // Logout & Dashboard Utama (Bisa diakses Admin, Petugas, Peminjam)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ---------------------------------------------------
    // KHUSUS ADMIN: Kelola Akun Petugas
    // ---------------------------------------------------
    Route::post('/tambah-petugas', [DashboardController::class, 'storePetugas'])->name('petugas.store');
    Route::delete('/hapus-petugas/{id}', [DashboardController::class, 'destroyPetugas'])->name('petugas.destroy');

    // ---------------------------------------------------
    // KHUSUS ADMIN & PETUGAS (Kelola Barang & Laporan)
    // ---------------------------------------------------
    Route::middleware('can:kelola-barang')->group(function () {
        
        // CRUD Buku
        Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');

        // Halaman Laporan & Approval Pengembalian
        Route::get('/laporan', [PeminjamanController::class, 'indexLaporan'])->name('laporan.index');
        Route::post('/peminjaman/{id}/terima', [PeminjamanController::class, 'terimaPengembalian'])->name('peminjaman.terima');
        Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolakPengembalian'])->name('peminjaman.tolak');
        Route::get('/laporan/cetak', [PeminjamanController::class, 'cetakLaporan'])->name('laporan.cetak');
    });

    // ---------------------------------------------------
    // KHUSUS PEMINJAM: Riwayat & Transaksi
    // ---------------------------------------------------
    Route::get('/peminjaman/riwayat', [PeminjamanController::class, 'index'])->name('peminjaman.riwayat');

    Route::middleware('can:meminjam')->group(function () {
        // Aksi Pinjam & Ulasan
        Route::post('/peminjaman/{buku_id}', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::post('/ulasan/{buku_id}', [UlasanController::class, 'store'])->name('ulasan.store');
        
        // Aksi Mengajukan Pengembalian Buku
        Route::post('/peminjaman/{id}/ajukan-kembali', [PeminjamanController::class, 'ajukanKembali'])->name('peminjaman.ajukan');
    });

});