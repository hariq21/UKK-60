<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">
    <div class="container-fluid px-0">
        <div class="row g-0 min-vh-100">
            @include('partials.sidebar.siswa')

            <main class="col p-3 p-md-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                    <div>
                        <h1 class="h3 mb-1">Dashboard Siswa</h1>
                        <p class="small text-secondary mb-0">Ringkasan laporan Anda</p>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted small mb-1">Selesai</p>
                                    <p class="h3 mb-0 text-success">{{ number_format($totalSelesai) }}</p>
                                </div>
                                <span class="text-success fs-4"><i class="bi bi-check-circle"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted small mb-1">Proses</p>
                                    <p class="h3 mb-0 text-primary">{{ number_format($totalDiproses) }}</p>
                                </div>
                                <span class="text-primary fs-4"><i class="bi bi-arrow-repeat"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted small mb-1">Verifikasi</p>
                                    <p class="h3 mb-0 text-warning">{{ number_format($totalVerifikasi) }}</p>
                                </div>
                                <span class="text-warning fs-4"><i class="bi bi-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header border-0 bg-body-tertiary py-3">
                        <h2 class="h6 mb-0">Data Laporan Singkat</h2>
                    </div>
                    <div class="table-responsive px-3 pb-3">
                        <table class="table table-borderless table-hover align-middle mb-0">
                            <thead class="small text-secondary">
                                <tr>
                                    <th class="fw-semibold py-2">ID</th>
                                    <th class="fw-semibold py-2">Judul</th>
                                    <th class="fw-semibold py-2">Kategori</th>
                                    <th class="fw-semibold py-2">Tgl</th>
                                    <th class="fw-semibold py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @forelse ($latestPengaduans as $pengaduan)
                                    @php
                                        $badge = match ($pengaduan->status) {
                                            \App\Models\Pengaduan::STATUS_SELESAI => 'text-bg-success',
                                            \App\Models\Pengaduan::STATUS_SEDANG_DIKERJAKAN => 'text-bg-primary',
                                            default => 'text-bg-warning',
                                        };
                                    @endphp
                                    <tr>
                                        <td>{{ $pengaduan->id }}</td>
                                        <td>{{ $pengaduan->judul ?: 'Tanpa judul' }}</td>
                                        <td>{{ $pengaduan->kategori }}</td>
                                        <td>{{ $pengaduan->created_at?->translatedFormat('d M y') }}</td>
                                        <td><span class="badge rounded-pill {{ $badge }} fw-normal">{{ $pengaduan->status_label }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Belum ada laporan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>

