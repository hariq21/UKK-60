<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pengaduan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">
    <div class="container-fluid px-0">
        <div class="row g-0 min-vh-100">
            @include('partials.sidebar.siswa')

            <main class="col p-3 p-md-4">
                <div class="mb-4">
                    <h1 class="h3 mb-1">Buat Pengaduan</h1>
                    <p class="text-muted mb-0">Isi data laporan secara jelas dan singkat.</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="alert alert-light border-0 shadow-sm d-flex align-items-center gap-2 mb-3 py-3">
                    <span class="d-inline-flex align-items-center justify-content-center text-primary" style="width: 20px;">
                        <i class="bi bi-info-circle"></i>
                    </span>
                    <div class="small text-secondary mb-0">
                        Tulis laporan secara jelas agar proses verifikasi dan tindak lanjut lebih cepat.
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3 p-md-4">
                        <form action="{{ route('siswa.pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="row g-4">
                            @csrf

                            <div class="col-12">
                                <h2 class="h6 mb-3">Informasi Laporan</h2>
                                <div class="row g-3">
                                    <div class="col-12 col-lg-8">
                                        <label class="form-label fw-semibold">Judul Pengaduan</label>
                                        <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" placeholder="Contoh: AC kelas 10 TKJ tidak berfungsi">
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label class="form-label fw-semibold">Kategori</label>
                                        <select name="kategori" class="form-select">
                                            <option value="">Pilih kategori</option>
                                            @foreach ($kategoriOptions as $kategori)
                                                <option value="{{ $kategori }}" @selected(old('kategori') === $kategori)>{{ $kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <h2 class="h6 mb-3">Detail Kejadian</h2>
                                <label class="form-label fw-semibold">Deskripsi</label>
                                <textarea name="deskripsi" rows="8" class="form-control" placeholder="Jelaskan lokasi, waktu, dan kondisi yang terjadi.">{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="col-12">
                                <h2 class="h6 mb-3">Lampiran</h2>
                                <label class="form-label fw-semibold">Foto Pendukung</label>
                                <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                                <small class="text-muted">Format yang didukung: JPG, PNG, WEBP.</small>
                            </div>

                            <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2 pt-2">
                                <small class="text-muted">Periksa kembali data sebelum mengirim.</small>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-light border">Kembali</a>
                                    <button type="submit" class="btn btn-primary px-4">Kirim Laporan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
