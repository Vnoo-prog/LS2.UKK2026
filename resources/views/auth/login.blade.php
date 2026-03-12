@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Login Dipus</h3>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Masuk</button>
                    
                    <div class="text-center mt-4">
                        <span class="text-muted">Peminjam baru?</span> 
                        <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Daftar Sekarang</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection