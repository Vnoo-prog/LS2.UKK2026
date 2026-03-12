<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::all();
        return view('buku.index', compact('bukus'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $request->validate(['judul' => 'required', 'penulis' => 'required', 'penerbit' => 'required', 'tahun_terbit' => 'required', 'stok' => 'required|numeric']);
        Buku::create($request->all());
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $request->validate(['stok' => 'required|numeric']);
        $buku->update($request->all());
        return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate');
    }
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    public function destroy($id)
    {
        Buku::destroy($id);
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus');
    }
}
