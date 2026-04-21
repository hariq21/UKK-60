<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::query()
            ->orderBy('id_kategori')
            ->orderBy('nama')
            ->get();

        return view('admin.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|unique:kategoris,id_kategori',
            'nama' => 'required'
    ]);

    Kategori::create([
        'id_kategori' => strtoupper(trim((string) $request->input('id_kategori'))),
        'nama' => trim((string) $request->input('nama')),
    ]);

    return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $kategori->update([
            'id_kategori' => strtoupper(trim((string) $request->input('id_kategori'))),
            'nama' => trim((string) $request->input('nama')),
        ]);

        return back();
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return back();
    }
}
