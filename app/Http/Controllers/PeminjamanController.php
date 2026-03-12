<?php
namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // UNTUK PEMINJAM: Melihat riwayatnya sendiri
    public function index() {
        $peminjamans = Peminjaman::with('buku')->where('user_id', Auth::id())->latest()->get();
        return view('peminjaman.index', compact('peminjamans'));
    }

    // AKSI MEMINJAM (Stok berkurang)
    public function store(Request $request, $buku_id) {
        $buku = Buku::findOrFail($buku_id);

        if ($buku->stok < 1) {
            return back()->with('error', 'Maaf, stok buku ini sedang kosong!');
        }

        $cekPinjam = Peminjaman::where('user_id', Auth::id())->where('buku_id', $buku_id)->whereIn('status_peminjaman', ['Dipinjam', 'Sedang Cek'])->first();
        if ($cekPinjam) {
            return back()->with('error', 'Kamu masih meminjam buku ini!');
        }

        Peminjaman::create([
            'user_id' => Auth::id(), 'buku_id' => $buku_id,
            'tanggal_peminjaman' => now()->format('Y-m-d'),
            'tanggal_pengembalian' => now()->addDays(7)->format('Y-m-d'), 
            'status_peminjaman' => 'Dipinjam'
        ]);

        $buku->decrement('stok'); // Kurangi stok 1
        return back()->with('success', 'Buku dipinjam! Tenggat: 1 minggu.');
    }

    public function ajukanKembali($id) {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status_peminjaman' => 'Sedang Cek']);
        return back()->with('success', 'Pengajuan pengembalian terkirim. Serahkan buku fisik ke petugas.');
    }


    public function indexLaporan(Request $request) {
        $query = Peminjaman::with(['buku', 'user']);
        
        if ($request->tgl_awal && $request->tgl_akhir) {
            $query->whereBetween('tanggal_peminjaman', [$request->tgl_awal, $request->tgl_akhir]);
        }
        
        $peminjamans = $query->latest()->get();
        return view('laporan.index', compact('peminjamans'));
    }
    public function terimaPengembalian($id) {
        $peminjaman = Peminjaman::findOrFail($id);
        
        $tenggat_waktu = Carbon::parse($peminjaman->tanggal_pengembalian);
        $hari_ini = now();
        $pesan_denda = '';

        if ($hari_ini->greaterThan($tenggat_waktu) && $hari_ini->diffInDays($tenggat_waktu) > 0) {
            $telat_hari = $tenggat_waktu->diffInDays($hari_ini);
            $denda = $telat_hari * 1000; 
            $pesan_denda = " (Telat $telat_hari hari. Denda: Rp " . number_format($denda, 0, ',', '.') . ")";
        }

        $peminjaman->update(['status_peminjaman' => 'Dikembalikan']);
        $peminjaman->buku->increment('stok'); // Tambah stok 1

        return back()->with('success', 'Buku diterima!' . $pesan_denda);
    }

    // PETUGAS TOLAK PENGEMBALIAN
    public function tolakPengembalian($id) {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status_peminjaman' => 'Dipinjam']); // Kembalikan statusnya
        return back()->with('error', 'Pengembalian ditolak! (Buku fisik belum diserahkan/rusak).');
    }

    // CETAK PDF (Sesuai Filter)
    public function cetakLaporan(Request $request) {
        $query = Peminjaman::with(['buku', 'user']);
        if ($request->tgl_awal && $request->tgl_akhir) {
            $query->whereBetween('tanggal_peminjaman', [$request->tgl_awal, $request->tgl_akhir]);
        }
        $peminjamans = $query->latest()->get();
        return view('laporan.cetak', compact('peminjamans'));
    }
}