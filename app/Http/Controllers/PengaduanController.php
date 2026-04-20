<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function adminIndex()
    {
        $pengaduans = Pengaduan::with('user')->latest()->get();

        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    public function adminShow(Request $request, Pengaduan $pengaduan)
    {
        $pengaduan->load('user');
        $isReadonly = $request->query('mode', 'view') === 'view';

        return view('admin.pengaduan.show', [
            'pengaduan' => $pengaduan,
            'statusOptions' => Pengaduan::STATUS_LABELS,
            'isReadonly' => $isReadonly,
        ]);
    }

    public function adminUpdate(Request $request, Pengaduan $pengaduan)
    {
        $pengaduan->update([
            'status' => $request->input('status') ?: $pengaduan->status,
            'umpan_balik' => trim((string) $request->input('umpan_balik')) ?: null,
        ]);

        return back();
    }

    public function adminDestroy(Pengaduan $pengaduan)
    {
        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index');
    }

    public function siswaIndex(Request $request)
    {
        $kategoriOptions = $this->getKategoriOptions();
        $pengaduans = Pengaduan::where('user_id', $request->user()->id)->latest()->get();

        return view('siswa.pengaduan.index', [
            'pengaduans' => $pengaduans,
            'kategoriOptions' => $kategoriOptions,
            'canCreatePengaduan' => !empty($kategoriOptions),
        ]);
    }

    public function siswaCreate()
    {
        return redirect()->route('siswa.pengaduan.index');
    }

    public function siswaShow(Request $request, Pengaduan $pengaduan)
    {
        abort_unless((int) $pengaduan->user_id === (int) $request->user()->id, 403);

        return view('siswa.pengaduan.show', ['pengaduan' => $pengaduan]);
    }

    public function siswaStore(Request $request)
    {
        $kategoriOptions = $this->getKategoriOptions();
        if (empty($kategoriOptions)) {
            return redirect()->route('siswa.pengaduan.index');
        }

        $fotoPath = $request->hasFile('foto')
            ? $request->file('foto')->store('pengaduan', 'public')
            : '';

        Pengaduan::create([
            'user_id' => $request->user()->id,
            'judul' => trim((string) $request->input('judul')),
            'kategori' => trim((string) $request->input('kategori')),
            'deskripsi' => trim((string) $request->input('deskripsi')),
            'foto' => $fotoPath,
            'status' => Pengaduan::STATUS_SEDANG_DIVERIFIKASI,
        ]);

        return redirect()->route('siswa.pengaduan.index');
    }

    public function siswaDestroy(Request $request, Pengaduan $pengaduan)
    {
        abort_unless((int) $pengaduan->user_id === (int) $request->user()->id, 403);

        $pengaduan->delete();

        return redirect()->route('siswa.pengaduan.index');
    }

    private function getKategoriOptions(): array
    {
        return Kategori::query()->orderBy('nama')->pluck('nama')->all();
    }
}
