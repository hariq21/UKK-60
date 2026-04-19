<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sarana Pengaduan Sekolah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">
    @php
        $isSiswaSelected = old('role_select') === 'siswa' || (filled(old('nis')) && !filled(old('nip')));
    @endphp

    <main class="min-vh-100 d-flex align-items-center">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-md-5">
                            <div class="text-center mb-4">                                
                                <h1 class="h3 fw-bold mb-1">Masuk Akun</h1>
                                <p class="text-muted mb-0">Sarana Pengaduan Sekolah</p>
                            </div>

                            <ul class="nav nav-pills nav-fill bg-body-tertiary rounded-4 p-1 mb-4" role="tablist">
                                <li class="nav-item w-50" role="presentation">
                                    <button class="nav-link rounded-3 fw-semibold small py-2 w-100 {{ $isSiswaSelected ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#siswa-pane" type="button" role="tab">Siswa</button>
                                </li>
                                <li class="nav-item w-50" role="presentation">
                                    <button class="nav-link rounded-3 fw-semibold small py-2 w-100 {{ $isSiswaSelected ? '' : 'active' }}" data-bs-toggle="pill" data-bs-target="#admin-pane" type="button" role="tab">Admin</button>
                                </li>
                            </ul>

                            <form action="{{ url('login') }}" method="POST">
                                @csrf

                                <div class="tab-content mb-3">
                                    <div class="tab-pane fade {{ $isSiswaSelected ? 'show active' : '' }}" id="siswa-pane" role="tabpanel">
                                        <label for="nis" class="form-label fw-semibold">NIS (Nomor Induk Siswa)</label>
                                        <input type="text" class="form-control rounded-3" id="nis" name="nis" placeholder="Contoh: 2310xxxx" value="{{ old('nis') }}">
                                    </div>
                                    <div class="tab-pane fade {{ $isSiswaSelected ? '' : 'show active' }}" id="admin-pane" role="tabpanel">
                                        <label for="nip" class="form-label fw-semibold">NIP (Nomor Induk Pegawai)</label>
                                        <input type="text" class="form-control rounded-3" id="nip" name="nip" placeholder="Contoh: 1980xxxx" value="{{ old('nip') }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Kata Sandi</label>
                                    <input type="password" class="form-control rounded-3" id="password" name="password" placeholder="Masukkan kata sandi">
                                </div>

                                <div class="text-end mb-3">
                                    <a href="#" class="small text-decoration-none"></a>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger py-2 mb-3" role="alert">
                                        {{ $errors->first() }}
                                    </div>
                                @endif

                                <button type="submit" class="btn btn-primary btn-lg rounded-3 w-100 fw-semibold">Login</button>
                            </form>
                        </div>
                    </div>

                    <p class="text-muted small mt-3 mb-0 text-center">&copy; 2024 Sarana Pengaduan Sekolah (SPS). Hak Cipta Dilindungi.</p>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
