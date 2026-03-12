<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Menampilkan Halaman Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Memproses Data Login (Tanpa Hash Password)
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Cek manual ke database karena password disimpan sebagai teks biasa (plain text)
        $user = User::where('username', $request->username)
                    ->where('password', $request->password)
                    ->first();

        // Jika user ditemukan dan password cocok
        if ($user) {
            Auth::login($user);
            $request->session()->regenerate(); // Mencegah celah keamanan Session Fixation
            
            return redirect()->route('dashboard')->with('success', 'Berhasil login!');
        }

        // Jika salah username atau password
        return back()->with('error', 'Username atau Password salah!');
    }

    // 3. Menampilkan Halaman Register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // 4. Memproses Data Register Peminjam
    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required',
            'alamat' => 'required'
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password, // Disimpan mentah (plain text)
            'alamat' => $request->alamat,
            'role' => 'peminjam' // Otomatis menjadi peminjam
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // 5. Memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        
        // Membersihkan seluruh memori session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}