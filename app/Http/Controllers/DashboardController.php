<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $bukus = Buku::with('ulasans.user')->get();
        $daftar_petugas = User::where('role', 'petugas')->get(); 
        
        return view('dashboard', compact('bukus', 'daftar_petugas'));
    }

    public function storePetugas(Request $request) {
        if(Auth::user()->role !== 'admin') abort(403);
        
        $request->validate([
            'username' => 'required|unique:users', 
            'password' => 'required', 
            'email' => 'required|unique:users', 
            'nama_lengkap' => 'required', 
            'alamat' => 'required'
        ]);
        
        User::create([
            'username' => $request->username, 
            'password' => $request->password, 
            'email' => $request->email,
            'nama_lengkap' => $request->nama_lengkap, 
            'alamat' => $request->alamat, 
            'role' => 'petugas'
        ]);
        
        return back()->with('success', 'Akun Petugas berhasil ditambahkan!');
    }

    public function destroyPetugas($id) {
        if(Auth::user()->role !== 'admin') abort(403);
        User::destroy($id);
        return back()->with('success', 'Akun Petugas berhasil dihapus!');
    }
}
