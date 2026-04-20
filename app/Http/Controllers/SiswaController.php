<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function dashboard(Request $request)
    {
        $baseQuery = Pengaduan::where('user_id', $request->user()->id);

        $totalPengaduan = (clone $baseQuery)->count();
        $totalSelesai = (clone $baseQuery)->where('status', Pengaduan::STATUS_SELESAI)->count();
        $totalDiproses = (clone $baseQuery)->where('status', Pengaduan::STATUS_SEDANG_DIKERJAKAN)->count();
        $totalVerifikasi = (clone $baseQuery)->where('status', Pengaduan::STATUS_SEDANG_DIVERIFIKASI)->count();
        $latestPengaduans = (clone $baseQuery)->latest()->take(8)->get();

        return view('siswa.dashboard.index', [
            'totalPengaduan' => $totalPengaduan,
            'totalSelesai' => $totalSelesai,
            'totalDiproses' => $totalDiproses,
            'totalVerifikasi' => $totalVerifikasi,
            'latestPengaduans' => $latestPengaduans,
        ]);
    }

}
