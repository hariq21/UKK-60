<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Admin</title>
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
                    <h1 class="h3 mb-1">Kategori Pengaduan</h1>
                    <p class="small text-secondary mb-0">Kelola klasifikasi pengaduan dengan tampilan dashboard yang clean.</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <div class="card border-0 shadow-sm kategori-table-card">
                    <div class="card-header border-0 bg-body-tertiary py-3 d-flex justify-content-between align-items-center">
                        <h2 class="h6 mb-0">Daftar Kategori</h2>
                        <button type="button" class="btn btn-primary btn-sm shadow-sm d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#createKategoriModal">
                            <i class="bi bi-plus-circle"></i>
                            <span>Tambah Kategori</span>
                        </button>
                    </div>
                    <div class="table-responsive px-3 pb-3 kategori-table-wrap">
                        <table class="table table-hover align-middle mb-0 js-datatable kategori-table">
                            <thead class="small text-secondary">
                                <tr>
                                    <th class="fw-semibold py-2" style="width: 72px;">No</th>
                                    <th class="fw-semibold py-2" style="width: 140px;">ID</th>
                                    <th class="fw-semibold py-2">Nama</th>
                                    <th class="fw-semibold py-2" style="width: 180px;">Dibuat</th>
                                    <th class="fw-semibold py-2 text-start" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @forelse ($kategoris as $kategori)
                                    <tr>
                                        <td class="text-secondary">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                                        <td>
                                            <span class="badge text-bg-light border">{{ $kategori->id_kategori ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $kategori->nama }}</span>
                                        </td>
                                        <td class="text-secondary">{{ $kategori->created_at?->translatedFormat('d M Y') }}</td>
                                        <td class="text-start">
                                            <div class="d-inline-flex justify-content-start align-items-center gap-1 w-100">
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-light border btn-icon-action"
                                                    title="Edit"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editKategoriModal"
                                                    data-update-url="{{ route('admin.kategori.update', $kategori) }}"
                                                    data-id-kategori="{{ $kategori->id_kategori }}"
                                                    data-nama="{{ $kategori->nama }}"
                                                >
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-light border text-danger btn-icon-action js-delete-trigger"
                                                    title="Hapus"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteKategoriModal"
                                                    data-delete-url="{{ route('admin.kategori.destroy', $kategori) }}"
                                                    data-kategori-nama="{{ $kategori->nama }}"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">
                                            <i class="bi bi-inbox d-block mb-2 fs-4"></i>
                                            Belum ada kategori.
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

    <div class="modal fade" id="createKategoriModal" tabindex="-1" aria-labelledby="createKategoriLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header border-0 pb-0">
                    <h3 class="h5 modal-title" id="createKategoriLabel">Tambah Kategori</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body pt-2">
                    <form action="{{ route('admin.kategori.store') }}" method="POST" class="row g-3">
                        @csrf
                        <input type="hidden" name="_form" value="create">

                        <div class="col-12">
                            <label for="id_kategori" class="form-label">ID Kategori</label>
                            <input
                                id="id_kategori"
                                type="text"
                                name="id_kategori"
                                value="{{ old('id_kategori') }}"
                                class="form-control"
                                placeholder="Contoh: KAT-001"
                            >
                        </div>

                        <div class="col-12">
                            <label for="nama" class="form-label">Nama Kategori</label>
                            <input id="nama" type="text" name="nama" value="{{ old('nama') }}" class="form-control" placeholder="Contoh: Infrastruktur">
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

    <div class="modal fade" id="editKategoriModal" tabindex="-1" aria-labelledby="editKategoriLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header border-0 pb-0">
                    <h3 class="h5 modal-title" id="editKategoriLabel">Edit Kategori</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body pt-2">
                    <form id="editKategoriForm" method="POST" class="row g-3">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="_form" value="edit">

                        <div class="col-12">
                            <label for="edit_id_kategori" class="form-label">ID Kategori</label>
                            <input id="edit_id_kategori" type="text" name="id_kategori" class="form-control">
                        </div>

                        <div class="col-12">
                            <label for="edit_nama" class="form-label">Nama Kategori</label>
                            <input id="edit_nama" type="text" name="nama" class="form-control">
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteKategoriModal" tabindex="-1" aria-labelledby="deleteKategoriLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header border-0 pb-0">
                    <h3 class="h5 modal-title" id="deleteKategoriLabel">Hapus Kategori</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="mb-0">
                        Apakah Kamu Yakin ingin menghapus kategori
                        <span id="deleteKategoriName" class="fw-semibold"></span>?
                    </p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteKategoriBtn">Iya</button>
                </div>
            </div>
        </div>
    </div>

    <form id="deleteKategoriForm" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editModal = document.getElementById('editKategoriModal');
            const createModal = document.getElementById('createKategoriModal');
            const deleteModal = document.getElementById('deleteKategoriModal');
            const shouldOpenCreate = document.body.dataset.shouldOpenCreate === 'true';

            if (editModal) {
                editModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;

                    if (!button) {
                        return;
                    }

                    const form = document.getElementById('editKategoriForm');
                    const idKategoriInput = document.getElementById('edit_id_kategori');
                    const namaInput = document.getElementById('edit_nama');

                    form.action = button.getAttribute('data-update-url') || '';
                    idKategoriInput.value = button.getAttribute('data-id-kategori') || '';
                    namaInput.value = button.getAttribute('data-nama') || '';
                });
            }

            if (shouldOpenCreate && createModal) {
                const createInstance = bootstrap.Modal.getOrCreateInstance(createModal);
                createInstance.show();
            }

            if (deleteModal) {
                const deleteName = document.getElementById('deleteKategoriName');
                const confirmDeleteBtn = document.getElementById('confirmDeleteKategoriBtn');
                const deleteForm = document.getElementById('deleteKategoriForm');
                let deleteActionUrl = '';

                deleteModal.addEventListener('show.bs.modal', function (event) {
                    const deleteButton = event.relatedTarget;

                    if (!deleteButton) {
                        return;
                    }

                    deleteActionUrl = deleteButton.getAttribute('data-delete-url') || '';
                    deleteName.textContent = deleteButton.getAttribute('data-kategori-nama') || 'ini';
                });

                confirmDeleteBtn.addEventListener('click', function () {
                    if (deleteActionUrl) {
                        deleteForm.action = deleteActionUrl;
                        deleteForm.submit();
                    }
                });
            }
        });
    </script>
</body>

</html>
