<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Siswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">
    <div class="container-fluid px-0">
        <div class="row g-0 min-vh-100">
            @include('partials.sidebar.siswa')

            <main class="col p-3 p-md-4">
                <div class="mb-4">
                    <h1 class="h3 mb-1">Profil Siswa</h1>
                    <p class="text-muted mb-0">Informasi akun dan data akademik Anda.</p>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex flex-column justify-content-center text-center">
                                <div class="mx-auto mb-3 d-inline-flex align-items-center justify-content-center rounded-circle bg-light text-secondary" style="width: 64px; height: 64px;">
                                    <i class="bi bi-person fs-4"></i>
                                </div>
                                <h2 class="h5 mb-1">{{ Auth::user()->name }}</h2>
                                <p class="text-muted mb-0">Siswa Aktif</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white">
                                <h2 class="h6 mb-0">Detail Akun</h2>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label text-muted small mb-1">Nama Lengkap</label>
                                        <div class="form-control bg-light">{{ Auth::user()->name }}</div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label text-muted small mb-1">NIS/NISN</label>
                                        <div class="form-control bg-light">{{ Auth::user()->nip }}</div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label text-muted small mb-1">Kelas</label>
                                        <div class="form-control bg-light">{{ Auth::user()->kelas ?: '-' }}</div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label text-muted small mb-1">Status</label>
                                        <div class="form-control bg-light">Aktif</div>
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
