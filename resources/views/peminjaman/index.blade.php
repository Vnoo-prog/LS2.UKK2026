@extends('layouts.app')
@section('content')
<h3 class="fw-bold mb-3">Riwayat Peminjaman Saya</h3>
<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-bordered mb-0 text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tenggat Waktu</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjamans as $p)
                <tr>
                    <td>{{ $p->buku->judul }}</td>
                    <td>{{ $p->tanggal_peminjaman }}</td>
                    <td>{{ $p->tanggal_pengembalian }}</td>
                    <td>
                        <span class="badge {{ $p->status_peminjaman == 'Dikembalikan' ? 'bg-success' : ($p->status_peminjaman == 'Sedang Cek' ? 'bg-warning' : 'bg-primary') }}">
                            {{ $p->status_peminjaman }}
                        </span>
                    </td>
                    <td>
                        @if($p->status_peminjaman == 'Dipinjam')
                        <form action="{{ route('peminjaman.ajukan', $p->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-warning">Ajukan Pengembalian</button>
                        </form>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection