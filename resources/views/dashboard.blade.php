@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h3 class="fw-bold">Dashboard Perpustakaan</h3>
        <p class="text-muted">Selamat datang, {{ Auth::user()->nama_lengkap }} ({{ ucfirst(Auth::user()->role) }}).</p>
    </div>
</div>

@if(Auth::user()->role === 'admin')
<div class="card shadow-sm mb-5 border-0">
    <div class="card-header bg-primary text-white fw-bold">
        Kelola Akun Petugas
    </div>
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger py-2 small">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('petugas.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-3 mb-2">
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required>
                </div>
                <div class="col-md-3 mb-2">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="col-md-2 mb-2">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="col-md-2 mb-2">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="col-md-2 mb-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">+ Tambah</button>
                </div>
                <div class="col-md-12 mt-2">
                    <input type="text" name="alamat" class="form-control" placeholder="Alamat Lengkap" required>
                </div>
            </div>
        </form>

        <h6 class="fw-bold border-bottom pb-2">Daftar Petugas Aktif</h6>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($daftar_petugas as $petugas)
                    <tr>
                        <td>{{ $petugas->nama_lengkap }}</td>
                        <td>{{ $petugas->username }}</td>
                        <td>{{ $petugas->email }}</td>
                        <td class="text-center">
                            <form action="{{ route('petugas.destroy', $petugas->id) }}" method="POST" onsubmit="return confirm('Pecat petugas ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">Belum ada akun petugas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<div class="row mb-3">
    <div class="col-12"><h4 class="fw-bold">Katalog Buku</h4></div>
</div>

<div class="row">
    @forelse($bukus as $b)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title fw-bold text-primary mb-1">{{ $b->judul }}</h5>
                <h6 class="card-subtitle mb-3 text-muted">Penulis: {{ $b->penulis }}</h6>
                
                <ul class="list-unstyled small mb-3">
                    <li><strong>Penerbit:</strong> {{ $b->penerbit }}</li>
                    <li><strong>Tahun:</strong> {{ $b->tahun_terbit }}</li>
                    <li><strong>Stok:</strong> <span class="badge {{ $b->stok > 0 ? 'bg-info' : 'bg-danger' }} text-dark">{{ $b->stok }} Tersisa</span></li>
                </ul>
                
                <hr>

                @can('meminjam')
                    <form action="{{ route('peminjaman.store', $b->id) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-{{ $b->stok > 0 ? 'success' : 'secondary' }} btn-sm w-100 fw-bold" {{ $b->stok < 1 ? 'disabled' : '' }}>
                            {{ $b->stok > 0 ? 'Pinjam Buku Ini' : 'Stok Buku Habis' }}
                        </button>
                    </form>

                    @php
                        $pernahPinjam = \App\Models\Peminjaman::where('user_id', Auth::id())
                                            ->where('buku_id', $b->id)
                                            ->exists();
                    @endphp

                    @if($pernahPinjam)
                        <form action="{{ route('ulasan.store', $b->id) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="input-group input-group-sm">
                                <input type="number" name="rating" class="form-control" placeholder="⭐ 1-5" min="1" max="5" required style="max-width: 80px;">
                                <input type="text" name="ulasan" class="form-control" placeholder="Tulis ulasan..." required>
                                <button class="btn btn-outline-primary" type="submit">Kirim</button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-secondary py-1 px-2 small text-center mb-3 border-0">
                            🔒 Pinjam buku ini terlebih dahulu untuk memberikan ulasan.
                        </div>
                    @endif
                @endcan

                <div class="mt-2">
                    <strong class="small d-block mb-2">Ulasan Pembaca:</strong>
                    <div style="max-height: 120px; overflow-y: auto; padding-right: 5px;">
                        @forelse($b->ulasans as $u)
                            <div class="mb-2 pb-2 border-bottom small">
                                <strong class="text-dark">{{ $u->user->username }}</strong> 
                                <span class="text-warning">
                                    @for($i=1; $i<=5; $i++)
                                        @if($i <= $u->rating) ★ @else ☆ @endif
                                    @endfor
                                </span>
                                <br>
                                <span class="text-muted">{{ $u->ulasan }}</span>
                            </div>
                        @empty
                            <span class="text-muted small">Belum ada ulasan.</span>
                        @endforelse
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <h5 class="text-muted">Belum ada buku di katalog.</h5>
    </div>
    @endforelse
</div>
@endsection