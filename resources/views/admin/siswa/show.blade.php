<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Siswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">
    <div class="container-fluid px-0">
        <div class="row g-0 min-vh-100">
            @include('partials.sidebar.admin')

            <main class="col p-3 p-md-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                    <div>
                        <h1 class="h3 mb-1">{{ $isReadonly ? 'View Siswa' : 'Edit Siswa' }}</h1>
                        <p class="text-muted mb-0">
                            {{ $isReadonly ? 'Tinjau detail data siswa.' : 'Perbarui data akun siswa.' }}
                        </p>
                    </div>
                    <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
                    </a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3 p-md-4">
                        <div class="mb-3">
                            <h3 class="h6 mb-1">{{ $isReadonly ? 'Detail Akun Siswa' : 'Update Akun Siswa' }}</h3>
                            <p class="small text-muted mb-0">
                                {{ $isReadonly ? 'Mode view: data tidak dapat diubah.' : 'Perbarui identitas dan kredensial akun siswa.' }}
                            </p>
                        </div>

                        <form action="{{ route('admin.siswa.update', $siswa) }}" method="POST" class="row g-3">
                            @csrf
                            @method('PATCH')

                            <div class="col-12">
                                <label class="form-label fw-semibold mb-2">Nama Lengkap</label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    value="{{ old('name', $siswa->name) }}"
                                    @disabled($isReadonly)
                                >
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold mb-2">NIS</label>
                                <input
                                    type="text"
                                    name="nip"
                                    class="form-control"
                                    value="{{ old('nip', $siswa->nip) }}"
                                    @disabled($isReadonly)
                                >
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold mb-2">Kelas</label>
                                <input
                                    type="text"
                                    name="kelas"
                                    class="form-control"
                                    value="{{ old('kelas', $siswa->kelas) }}"
                                    @disabled($isReadonly)
                                >
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold mb-2">Password Baru</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    @disabled($isReadonly)
                                >
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold mb-2">Konfirmasi Password Baru</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    @disabled($isReadonly)
                                >
                            </div>

                            @unless($isReadonly)
                                <div class="col-12 d-flex justify-content-end pt-1">
                                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                                </div>
                            @endunless
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
