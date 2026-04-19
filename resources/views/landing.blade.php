<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aspirasi Sekolah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">
    <header class="bg-white border-bottom">
        <nav class="navbar navbar-expand-lg container py-1">
            <a class="navbar-brand d-inline-flex align-items-center gap-2 mb-0" href="{{ url('/') }}">
                <img
                    src="{{ asset('images/aspirasiku-logo-cropped.png') }}"
                    alt="Logo AspirasiKu"
                    style="height: 38px; width: auto; display: block;"
                >
                <span style="font-size: 1.7rem; line-height: 1; letter-spacing: -0.02em; font-weight: 700;">
                    Aspirasi<span class="text-primary" style="font-size: inherit; font-weight: inherit; line-height: inherit;">Ku</span>
                </span>
            </a>
            <div class="ms-auto d-flex align-items-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-primary px-3 py-1">Login</a>
            </div>
        </nav>
    </header>

    <main>
        <section class="py-4 py-lg-5 border-bottom">
            <div class="container py-2 py-lg-3">
                <div class="row align-items-center g-3 g-lg-4">
                    <div class="col-12 col-lg-6">
                        <h1 class="display-6 fw-bold lh-sm mb-3">
                            Sampaikan Aspirasi Anda Secara
                            <span class="text-primary">Mudah</span>
                            <span class="text-primary">&amp; Aman</span>
                        </h1>
                        <p class="text-secondary fs-5 mb-4">
                            Platform resmi untuk memfasilitasi komunikasi antara warga sekolah dan pihak manajemen
                            demi peningkatan kualitas pendidikan.
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2">Buat Laporan</a>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="card border-0 shadow-sm">
                            <div class="ratio ratio-4x3">
                                <img
                                    src="{{ request()->getBaseUrl() }}/images/smkn4-praktik.jpeg"
                                    class="w-100 h-100 rounded object-fit-cover"
                                    alt="Siswa praktik di SMKN 4 Tangerang"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="fitur" class="py-4 border-bottom bg-white">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-12 col-lg-7">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="d-flex align-items-start gap-2">
                                    <span class="badge text-bg-primary rounded-pill">1</span>
                                    <div>
                                        <h6 class="mb-1">Lapor</h6>
                                        <small class="text-muted">Tulis aspirasi Anda</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-start gap-2">
                                    <span class="badge text-bg-primary rounded-pill">2</span>
                                    <div>
                                        <h6 class="mb-1">Verifikasi</h6>
                                        <small class="text-muted">Divalisasi petugas</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-start gap-2">
                                    <span class="badge text-bg-primary rounded-pill">3</span>
                                    <div>
                                        <h6 class="mb-1">Proses</h6>
                                        <small class="text-muted">Tindak lanjut sekolah</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-start gap-2">
                                    <span class="badge text-bg-primary rounded-pill">4</span>
                                    <div>
                                        <h6 class="mb-1">Selesai</h6>
                                        <small class="text-muted">Dapatkan notifikasi</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="row text-center g-2">
                            <div class="col-4">
                                <h3 class="fw-bold text-primary mb-0">1.2K+</h3>
                                <small class="text-muted">Total Laporan</small>
                            </div>
                            <div class="col-4">
                                <h3 class="fw-bold text-primary mb-0">94%</h3>
                                <small class="text-muted">Tuntas</small>
                            </div>
                            <div class="col-4">
                                <h3 class="fw-bold text-primary mb-0">24h</h3>
                                <small class="text-muted">Avg Respon</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <h2 class="h3 text-center fw-bold mb-4">Suara Siswa</h2>
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <p class="text-muted">"Saya melaporkan AC kelas yang rusak, dua hari kemudian langsung diperbaiki."</p>
                                <p class="fw-semibold mb-0">Budi, Kelas XII IPA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <p class="text-muted">"Saran lomba diterima OSIS dan sekolah. Prosesnya jelas dan cepat."</p>
                                <p class="fw-semibold mb-0">Siti, Kelas XI IPS</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <p class="text-muted">"Lapor wastafel mampet jadi gampang. Tinggal foto dan kirim."</p>
                                <p class="fw-semibold mb-0">Rian, Kelas X Merdeka</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

</html>
