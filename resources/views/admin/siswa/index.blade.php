<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-light"
    data-should-open-create="{{ ($errors->any() && old('_form') === 'create') ? 'true' : 'false' }}"
>
    <div class="container-fluid px-0">
        <div class="row g-0 min-vh-100">
            @include('partials.sidebar.admin')

            <main class="col p-3 p-md-4">
                <div class="mb-4">
                    <h1 class="h3 mb-1">Data Siswa</h1>
                    <p class="small text-secondary mb-0">Kelola data akun siswa dengan tampilan dashboard</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <div class="card border-0 shadow-sm kategori-table-card">
                    <div class="card-header border-0 bg-body-tertiary py-3 d-flex justify-content-between align-items-center">
                        <h2 class="h6 mb-0">Daftar Siswa</h2>
                        <button type="button" class="btn btn-primary btn-sm shadow-sm d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#createSiswaModal">
                            <i class="bi bi-plus-circle"></i>
                            <span>Tambah Siswa</span>
                        </button>
                    </div>
                    <div class="table-responsive px-3 pb-3 kategori-table-wrap">
                        <table class="table table-hover align-middle mb-0 js-datatable kategori-table">
                            <thead class="small text-secondary">
                                <tr>
                                    <th class="fw-semibold py-2" style="width: 72px;">No</th>
                                    <th class="fw-semibold py-2">Nama</th>
                                    <th class="fw-semibold py-2" style="width: 180px;">NIS</th>
                                    <th class="fw-semibold py-2" style="width: 160px;">Kelas</th>
                                    <th class="fw-semibold py-2" style="width: 180px;">Dibuat</th>
                                    <th class="fw-semibold py-2 text-start" style="width: 160px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @forelse ($siswas as $siswa)
                                    <tr>
                                        <td class="text-secondary">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $siswa->name }}</td>
                                        <td><span class="badge text-bg-light border">{{ $siswa->nip }}</span></td>
                                        <td>{{ $siswa->kelas }}</td>
                                        <td class="text-secondary">{{ $siswa->created_at?->translatedFormat('d M Y') }}</td>
                                        <td class="text-start">
                                            <div class="d-inline-flex justify-content-start align-items-center gap-1 w-100">
                                                <a
                                                    href="{{ route('admin.siswa.show', ['siswa' => $siswa, 'mode' => 'view']) }}"
                                                    class="btn btn-sm btn-light border btn-icon-action"
                                                >
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a
                                                    href="{{ route('admin.siswa.show', ['siswa' => $siswa, 'mode' => 'edit']) }}"
                                                    class="btn btn-sm btn-light border btn-icon-action"
                                                >
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-light border text-danger btn-icon-action js-delete-siswa-trigger"
                                                    title="Hapus"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteSiswaModal"
                                                    data-delete-url="{{ route('admin.siswa.destroy', $siswa) }}"
                                                    data-siswa-name="{{ $siswa->name }}"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <i class="bi bi-inbox d-block mb-2 fs-4"></i>
                                            Belum ada data siswa.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="createSiswaModal" tabindex="-1" aria-labelledby="createSiswaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header border-0 pb-0">
                    <h3 class="h5 modal-title" id="createSiswaLabel">Tambah Siswa</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body pt-2">
                    <form action="{{ route('admin.siswa.store') }}" method="POST" class="row g-3">
                        @csrf
                        <input type="hidden" name="_form" value="create">

                        <div class="col-12">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="nip" class="form-label">NIS</label>
                            <input id="nip" type="text" name="nip" value="{{ old('nip') }}" class="form-control">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input id="kelas" type="text" name="kelas" value="{{ old('kelas') }}" class="form-control">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" name="password" class="form-control">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control">
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteSiswaModal" tabindex="-1" aria-labelledby="deleteSiswaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header border-0 pb-0">
                    <h3 class="h5 modal-title" id="deleteSiswaLabel">Hapus Siswa</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="mb-0">
                        Apakah Kamu Yakin ingin menghapus siswa
                        <span id="deleteSiswaName" class="fw-semibold"></span>?
                    </p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteSiswaBtn">Iya</button>
                </div>
            </div>
        </div>
    </div>

    <form id="deleteSiswaForm" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const createModal = document.getElementById('createSiswaModal');
            const shouldOpenCreate = document.body.dataset.shouldOpenCreate === 'true';
            const deleteModal = document.getElementById('deleteSiswaModal');

            if (shouldOpenCreate && createModal) {
                const createInstance = bootstrap.Modal.getOrCreateInstance(createModal);
                createInstance.show();
            }

            if (!deleteModal) {
                return;
            }

            const deleteName = document.getElementById('deleteSiswaName');
            const confirmDeleteBtn = document.getElementById('confirmDeleteSiswaBtn');
            const deleteForm = document.getElementById('deleteSiswaForm');
            let deleteActionUrl = '';

            deleteModal.addEventListener('show.bs.modal', function (event) {
                const deleteButton = event.relatedTarget;

                if (!deleteButton) {
                    return;
                }

                deleteActionUrl = deleteButton.getAttribute('data-delete-url') || '';
                deleteName.textContent = deleteButton.getAttribute('data-siswa-name') || 'ini';
            });

            confirmDeleteBtn.addEventListener('click', function () {
                if (deleteActionUrl) {
                    deleteForm.action = deleteActionUrl;
                    deleteForm.submit();
                }
            });
        });
    </script>
</body>

</html>
