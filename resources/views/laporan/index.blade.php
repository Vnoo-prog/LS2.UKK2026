@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Laporan & Persetujuan Pengembalian</h3>
</div>

<div class="card shadow-sm border-0 mb-4 bg-light">
    <div class="card-body">
        <form action="{{ route('laporan.index') }}" method="GET" class="row align-items-end">
            <div class="col-md-3">
                <label class="small fw-bold">Dari Tanggal (Peminjaman)</label>
                <input type="date" name="tgl_awal" class="form-control" value="{{ request('tgl_awal') }}">
            </div>
            <div class="col-md-3">
                <label class="small fw-bold">Sampai Tanggal</label>
                <input type="date" name="tgl_akhir" class="form-control" value="{{ request('tgl_akhir') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary fw-bold">Filter</button>
                <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary">Reset</a>
                
                <a href="{{ route('laporan.cetak', ['tgl_awal' => request('tgl_awal'), 'tgl_akhir' => request('tgl_akhir')]) }}" target="_blank" class="btn btn-warning fw-bold">🖨️ Cetak PDF</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center">
            <thead class="table-dark">
                <tr>
                    <th>Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tenggat</th>
                    <th>Status</th>
                    <th>Persetujuan Petugas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjamans as $p)
                <tr>
                    <td class="fw-bold">{{ $p->user->nama_lengkap }}</td>
                    <td>{{ $p->buku->judul }}</td>
                    <td>{{ $p->tanggal_peminjaman }}</td>
                    <td class="{{ now()->greaterThan($p->tanggal_pengembalian) && $p->status_peminjaman != 'Dikembalikan' ? 'text-danger fw-bold' : '' }}">
                        {{ $p->tanggal_pengembalian }}
                    </td>
                    <td><span class="badge bg-secondary">{{ $p->status_peminjaman }}</span></td>
                    <td>
                        @if($p->status_peminjaman == 'Sedang Cek')
                        <div class="d-flex justify-content-center gap-2">
                            <form action="{{ route('peminjaman.terima', $p->id) }}" method="POST">
                                @csrf <button class="btn btn-sm btn-success fw-bold">Terima</button>
                            </form>
                            <form action="{{ route('peminjaman.tolak', $p->id) }}" method="POST">
                                @csrf <button class="btn btn-sm btn-danger fw-bold">Tolak</button>
                            </form>
                        </div>
                        @else
                        <span class="text-muted small">Selesai / Belum Diajukan</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection