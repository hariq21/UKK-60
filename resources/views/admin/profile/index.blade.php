<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">
    <div class="container-fluid px-0">
        <div class="row g-0 min-vh-100">
            @include('partials.sidebar.admin')

            <main class="col p-3 p-md-4">
                <div class="mb-4">
                    <h1 class="h3 mb-1">Profil Admin</h1>
                    <p class="text-muted mb-0">Ubah NIP dan password akun admin.</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-0">
                        <div class="d-flex align-items-center gap-3">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light text-secondary" style="width: 52px; height: 52px;">
                                <i class="bi bi-person fs-5"></i>
                            </span>
                            <div>
                                <h2 class="h5 mb-0">{{ Auth::user()->name }}</h2>
                                <small class="text-muted">Administrator</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.profile.update') }}" method="POST" class="row g-3">
                            @csrf
                            @method('PATCH')

                            <div class="col-12">
                                <label for="nip" class="form-label fw-semibold">NIP</label>
                                <input
                                    id="nip"
                                    type="text"
                                    name="nip"
                                    value="{{ old('nip', Auth::user()->nip) }}"
                                    class="form-control"
                                >
                            </div>

                            <div class="col-12 col-lg-6">
                                <label for="password" class="form-label fw-semibold">Password Baru</label>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Kosongkan jika tidak diubah"
                                >
                            </div>

                            <div class="col-12 col-lg-6">
                                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="Ulangi password baru"
                                >
                            </div>

                            <div class="col-12 d-flex justify-content-end pt-2">
                                <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
