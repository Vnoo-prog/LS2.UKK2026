@extends('layouts.app')

@section('content')
<div class="card shadow-sm col-md-6 mx-auto">
    <div class="card-header bg-white fw-bold">Edit Data Buku</div>
    <div class="card-body">
        <form action="{{ route('buku.update', $buku->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3"><label>Judul Buku</label><input type="text" name="judul" class="form-control" value="{{ $buku->judul }}" required></div>
            <div class="mb-3"><label>Penulis</label><input type="text" name="penulis" class="form-control" value="{{ $buku->penulis }}" required></div>
            <div class="mb-3"><label>Penerbit</label><input type="text" name="penerbit" class="form-control" value="{{ $buku->penerbit }}" required></div>
            <div class="mb-3"><label>Tahun Terbit</label><input type="number" name="tahun_terbit" class="form-control" value="{{ $buku->tahun_terbit }}" required></div>
            <div class="mb-3"><label>Stok Buku</label><input type="number" name="stok" class="form-control" value="{{ $buku->stok }}" required></div>
            <button type="submit" class="btn btn-warning w-100">Update Buku</button>
        </form>
    </div>
</div>
@endsection