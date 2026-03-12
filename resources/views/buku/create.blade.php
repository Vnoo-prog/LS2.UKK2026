@extends('layouts.app')

@section('content')
<div class="card shadow-sm col-md-6 mx-auto">
    <div class="card-header bg-white fw-bold">Tambah Buku Baru</div>
    <div class="card-body">
        <form action="{{ route('buku.store') }}" method="POST">
            @csrf
            <div class="mb-3"><label>Judul Buku</label><input type="text" name="judul" class="form-control" required></div>
            <div class="mb-3"><label>Penulis</label><input type="text" name="penulis" class="form-control" required></div>
            <div class="mb-3"><label>Penerbit</label><input type="text" name="penerbit" class="form-control" required></div>
            <div class="mb-3"><label>Tahun Terbit</label><input type="number" name="tahun_terbit" class="form-control" required></div>
            <div class="mb-3"><label>Stok Buku</label><input type="number" name="stok" class="form-control" required></div>
            <button type="submit" class="btn btn-primary w-100">Simpan Buku</button>
        </form>
    </div>
</div>
@endsection