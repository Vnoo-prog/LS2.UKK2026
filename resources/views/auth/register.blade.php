@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-success">Daftar Peminjam Baru</h3>
                    <p class="text-muted small">Lengkapi data diri Anda untuk mulai meminjam buku.</p>
                </div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama asli" required autofocus>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email aktif" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username untuk login" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Buat password" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Sertakan RT/RW dan kode pos..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold">Daftar Akun Peminjam</button>
                    
                    <div class="text-center mt-4">
                        <span class="text-muted">Sudah punya akun?</span> 
                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-success">Login di sini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection