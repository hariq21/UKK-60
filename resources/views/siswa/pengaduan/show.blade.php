<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengaduan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">
    <div class="container-fluid px-0">
        <div class="row g-0 min-vh-100">
            @include('partials.sidebar.siswa')

            <main class="col p-3 p-md-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                    <div>
                        <h1 class="h3 mb-1">Detail Laporan</h1>
                        <p class="text-muted mb-0">Data lengkap laporan pengaduan Anda.</p>
                    </div>
                    <a href="{{ route('siswa.pengaduan.index') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
                    </a>
                </div>

                @php
                    $badge = match ($pengaduan->status) {
                        \App\Models\Pengaduan::STATUS_SELESAI => 'text-bg-success',
                        \App\Models\Pengaduan::STATUS_SEDANG_DIKERJAKAN => 'text-bg-primary',
                        default => 'text-bg-warning',
                    };
                @endphp

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3 p-md-4 p-lg-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 pb-1 mb-2">
                            <div>
                                <h2 class="h4 mb-1">{{ $pengaduan->judul ?: 'Tanpa Judul' }}</h2>
                                <p class="small text-muted mb-0">
                                    <i class="bi bi-clock me-1"></i>Dilaporkan pada {{ $pengaduan->created_at?->translatedFormat('d M Y, H:i') }}
                                </p>
                            </div>
                            <span class="badge rounded-pill fw-normal px-3 py-2 {{ $badge }}">{{ $pengaduan->status_label }}</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-lg-5">
                                <div class="rounded-3 overflow-hidden bg-white">
                                    <div class="ratio ratio-4x3">
                                        @if (filled($pengaduan->foto))
                                            <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto Pengaduan" class="w-100 h-100 shadow-none" style="object-fit: contain; background: #f8f9fc;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center w-100 h-100 text-muted text-center px-3" style="background: #f8f9fc;">
                                                Foto belum diunggah.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-7">
                                <div class="bg-body-tertiary rounded-3 p-3 mb-3">
                                    <p class="small text-muted fw-semibold mb-1">Kategori</p>
                                    <p class="mb-0">{{ $pengaduan->kategori }}</p>
                                </div>

                                <div class="bg-body-tertiary rounded-3 p-3 mb-3">
                                    <p class="small text-muted fw-semibold mb-1">Deskripsi</p>
                                    <p class="mb-0 lh-base">{{ $pengaduan->deskripsi }}</p>
                                </div>

                                <div class="bg-body-tertiary rounded-3 p-3">
                                    <p class="small text-muted fw-semibold mb-1">Umpan Balik Admin</p>
                                    @if ($pengaduan->umpan_balik)
                                        <div class="rounded-3 bg-success-subtle p-3">
                                            <p class="mb-0 text-success-emphasis">{{ $pengaduan->umpan_balik }}</p>
                                        </div>
                                    @else
                                        <p class="mb-0 text-muted">Belum ada umpan balik dari admin.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>

