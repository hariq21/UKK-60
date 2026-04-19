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
            @include('partials.sidebar.admin')

            <main class="col p-3 p-md-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                    <div>
                        <h1 class="h3 mb-1">{{ $isReadonly ? 'View Pengaduan' : 'Edit Pengaduan' }}</h1>
                        <p class="text-muted mb-0">
                            {{ $isReadonly ? 'Tinjau detail laporan siswa.' : 'Tinjau laporan lalu perbarui status dan umpan balik.' }}
                        </p>
                    </div>
                    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                @php
                    $statusBadge = match ($pengaduan->status) {
                        \App\Models\Pengaduan::STATUS_SELESAI => 'text-bg-success',
                        \App\Models\Pengaduan::STATUS_SEDANG_DIKERJAKAN => 'text-bg-primary',
                        default => 'text-bg-warning',
                    };
                @endphp

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
                            <div>
                                <h2 class="h5 mb-1">{{ $pengaduan->judul ?: 'Tanpa Judul' }}</h2>
                                <p class="small text-muted mb-0">
                                    <i class="bi bi-calendar-event me-1"></i>{{ $pengaduan->created_at?->translatedFormat('d M Y, H:i') }}
                                    | {{ $pengaduan->user?->name ?? '-' }}
                                </p>
                            </div>
                            <span class="badge rounded-pill fw-normal {{ $statusBadge }}">{{ $pengaduan->status_label }}</span>
                        </div>

                        <div class="row g-4">
                            <div class="col-12 col-lg-5">
                                <div class="rounded-3 overflow-hidden bg-white">
                                    <div class="ratio ratio-4x3">
                                        @if (filled($pengaduan->foto))
                                            <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto Pengaduan" class="w-100 h-100" style="object-fit: contain; background: #f8f9fc;">
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

                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                                        <div>
                                            <h3 class="h6 mb-1">{{ $isReadonly ? 'Detail Laporan' : 'Update Laporan' }}</h3>
                                            <p class="small text-muted mb-0">
                                                {{ $isReadonly ? 'Mode view: data tidak dapat diubah.' : 'Perbarui status dan beri catatan untuk siswa.' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <form action="{{ route('admin.pengaduan.update', $pengaduan) }}" method="POST" class="row g-3">
                                            @csrf
                                            @method('PATCH')

                                            <div class="col-12">
                                                <label class="form-label fw-semibold mb-2">Status Laporan</label>
                                                <select name="status" class="form-select" @disabled($isReadonly)>
                                                    @foreach ($statusOptions as $statusValue => $statusLabel)
                                                        <option value="{{ $statusValue }}" @selected($pengaduan->status === $statusValue)>{{ $statusLabel }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label fw-semibold mb-2">Umpan Balik untuk Siswa</label>
                                                <textarea name="umpan_balik" class="form-control" rows="4" placeholder="Tulis umpan balik untuk siswa" @disabled($isReadonly)>{{ $pengaduan->umpan_balik }}</textarea>
                                                <div class="form-text">
                                                    {{ $isReadonly ? 'Umpan balik ditampilkan sebagai informasi.' : 'Contoh: laporan sudah diverifikasi dan sedang ditindaklanjuti.' }}
                                                </div>
                                            </div>

                                            @unless($isReadonly)
                                                <div class="col-12 d-flex justify-content-end pt-1">
                                                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                                                </div>
                                            @endunless
                                        </form>
                                    </div>
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
