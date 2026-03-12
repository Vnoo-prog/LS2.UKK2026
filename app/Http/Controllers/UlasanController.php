<?php

namespace App\Http\Controllers;

use App\Models\UlasanBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function store(Request $request, $buku_id)
    {
        $request->validate([
            'ulasan' => 'required',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        UlasanBuku::create([
            'user_id' => Auth::id(),
            'buku_id' => $buku_id,
            'ulasan' => $request->ulasan,
            'rating' => $request->rating
        ]);

        return back()->with('success', 'Ulasan berhasil ditambahkan!');
    }
}
