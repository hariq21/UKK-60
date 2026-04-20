<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $query = Pengaduan::query();
        $totalPengaduan = (clone $query)->count();
        $totalSelesai = (clone $query)->where('status', Pengaduan::STATUS_SELESAI)->count();
        $totalDiproses = (clone $query)->whereIn('status', [
            Pengaduan::STATUS_SEDANG_DIVERIFIKASI,
            Pengaduan::STATUS_SEDANG_DIKERJAKAN,
        ])->count();
        $latestPengaduans = (clone $query)->with('user')->latest()->take(8)->get();

        return view('admin.dashboard.index', compact('totalPengaduan', 'totalSelesai', 'totalDiproses', 'latestPengaduans'));
    }

    public function profileShow()
    {
        return view('admin.profile.index');
    }

    public function profileUpdate(Request $request)
    {
        $user = $request->user();
        abort_unless($user instanceof User, 403);

        $payload = ['nip' => trim((string) $request->input('nip'))];
        if ($request->filled('password')) {
            $payload['password'] = $request->input('password');
        }

        $user->update($payload);

        return back();
    }

    public function siswaCreate()
    {
        $siswas = User::query()
            ->where('role', 'siswa')
            ->latest()
            ->get(['id', 'name', 'nip', 'kelas', 'created_at']);

        return view('admin.siswa.index', compact('siswas'));
    }

    public function siswaStore(Request $request)
    {
        User::create([
            'name' => trim((string) $request->input('name')),
            'nip' => trim((string) $request->input('nip')),
            'kelas' => trim((string) $request->input('kelas')),
            'role' => 'siswa',
            'password' => (string) $request->input('password'),
        ]);

        return redirect()->route('admin.siswa.create');
    }

    public function siswaShow(Request $request, User $siswa)
    {
        abort_unless($siswa->role === 'siswa', 404);
        $isReadonly = $request->query('mode', 'view') === 'view';

        return view('admin.siswa.show', compact('siswa', 'isReadonly'));
    }

    public function siswaUpdate(Request $request, User $siswa)
    {
        abort_unless($siswa->role === 'siswa', 404);

        $payload = [
            'name' => trim((string) $request->input('name')),
            'nip' => trim((string) $request->input('nip')),
            'kelas' => trim((string) $request->input('kelas')),
        ];

        if ($request->filled('password')) {
            $payload['password'] = $request->input('password');
        }

        $siswa->update($payload);

        return back();
    }

    public function siswaDestroy(User $siswa)
    {
        abort_unless($siswa->role === 'siswa', 404);
        $siswa->delete();

        return redirect()->route('admin.siswa.create');
    }
}
