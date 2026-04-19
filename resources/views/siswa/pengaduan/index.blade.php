<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Siswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-light"
    data-should-open-create="{{ ($errors->any() && old('_form') === 'create') ? 'true' : 'false' }}"
>
    <div class="container-fluid px-0">
        <div class="row g-0 min-vh-100">
            @include('partials.sidebar.siswa')

            <main class="col p-3 p-md-4">
                <div class="mb-4">
                    <h1 class="h3 mb-1">Pengaduan</h1>
                    <p class="text-muted mb-0">Buat dan kelola laporan pengaduan Anda.</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <div class="card border-0 shadow-sm kategori-table-card">
                    <div class="card-header border-0 bg-body-tertiary py-3 d-flex justify-content-between align-items-center">
                        <h2 class="h6 mb-0">Daftar Pengaduan</h2>
                        <button type="button" class="btn btn-primary btn-sm shadow-sm d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#createPengaduanModal">
                            <i class="bi bi-plus-circle"></i>
                            <span>Buat Pengaduan</span>
                        </button>
                    </div>
                    <div class="table-responsive px-3 pb-3 kategori-table-wrap">
                        <table class="table table-hover align-middle mb-0 js-datatable kategori-table">
                            <thead class="small text-secondary">
                                <tr>
                                    <th class="fw-semibold py-2" style="width: 72px;">No</th>
                                    <th class="fw-semibold py-2">Judul</th>
                                    <th class="fw-semibold py-2" style="width: 180px;">Kategori</th>
                                    <th class="fw-semibold py-2" style="width: 180px;">Tanggal</th>
                                    <th class="fw-semibold py-2 text-start" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @forelse ($pengaduans as $pengaduan)
                                    <tr>
                                        <td class="text-secondary">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $pengaduan->judul ?: 'Tanpa Judul' }}</td>
                                        <td><span class="badge text-bg-light border">{{ $pengaduan->kategori }}</span></td>
                                        <td class="text-secondary">{{ $pengaduan->created_at?->translatedFormat('d M Y') }}</td>
                                        <td class="text-start">
                                            <div class="d-inline-flex justify-content-start align-items-center gap-1 w-100">
                                                <a
                                                    href="{{ route('siswa.pengaduan.show', $pengaduan) }}"
                                                    class="btn btn-sm btn-light border btn-icon-action"
                                                    title="View"
                                                >
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-light border text-danger btn-icon-action"
                                                    title="Hapus"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deletePengaduanModal"
                                                    data-delete-url="{{ route('siswa.pengaduan.destroy', $pengaduan) }}"
                                                    data-pengaduan-title="{{ $pengaduan->judul ?: 'Tanpa Judul' }}"
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
                                            Belum ada pengaduan.
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

    <div class="modal fade" id="createPengaduanModal" tabindex="-1" aria-labelledby="createPengaduanLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header border-0 pb-0">
                    <h3 class="h5 modal-title" id="createPengaduanLabel">Buat Pengaduan</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body pt-2">
                    <form action="{{ route('siswa.pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        <input type="hidden" name="_form" value="create">

                        <div class="col-12 col-lg-8">
                            <label class="form-label fw-semibold">Judul Pengaduan</label>
                            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" placeholder="Contoh: AC kelas 10 TKJ tidak berfungsi">
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label fw-semibold">Kategori</label>
                            <select name="kategori" class="form-select" @disabled(!$canCreatePengaduan)>
                                @if ($canCreatePengaduan)
                                    <option value="">Pilih kategori</option>
                                    @foreach ($kategoriOptions as $kategori)
                                        <option value="{{ $kategori }}" @selected(old('kategori') === $kategori)>{{ $kategori }}</option>
                                    @endforeach
                                @else
                                    <option value="">Belum ada kategori dari admin</option>
                                @endif
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" rows="6" class="form-control" placeholder="Jelaskan lokasi, waktu, dan kondisi yang terjadi.">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Foto Pendukung</label>
                            <input id="foto_pengaduan" type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                            <small class="text-muted">Format: JPG, PNG, WEBP.</small>
                            <div id="foto_preview_wrap" class="mt-2 d-none">
                                <div class="border rounded-3 p-2 bg-body-tertiary">
                                    <img id="foto_preview_img" src="" alt="Preview Foto" class="w-100 rounded-2" style="max-height: 240px; object-fit: contain;">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" @disabled(!$canCreatePengaduan)>Kirim Laporan</button>
                        </div>
                        @if (!$canCreatePengaduan)
                            <div class="col-12">
                                <small class="text-danger">Kategori belum tersedia. Minta admin menambahkan kategori terlebih dahulu.</small>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletePengaduanModal" tabindex="-1" aria-labelledby="deletePengaduanLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header border-0 pb-0">
                    <h3 class="h5 modal-title" id="deletePengaduanLabel">Hapus Pengaduan</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="mb-0">
                        Apakah Kamu Yakin ingin menghapus pengaduan
                        <span id="deletePengaduanTitle" class="fw-semibold"></span>?
                    </p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-danger" id="confirmDeletePengaduanBtn">Iya</button>
                </div>
            </div>
        </div>
    </div>

    <form id="deletePengaduanForm" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const createModal = document.getElementById('createPengaduanModal');
            const shouldOpenCreate = document.body.dataset.shouldOpenCreate === 'true';
            const fotoInput = document.getElementById('foto_pengaduan');
            const fotoPreviewWrap = document.getElementById('foto_preview_wrap');
            const fotoPreviewImg = document.getElementById('foto_preview_img');

            if (shouldOpenCreate && createModal) {
                const createInstance = bootstrap.Modal.getOrCreateInstance(createModal);
                createInstance.show();
            }

            if (fotoInput && fotoPreviewWrap && fotoPreviewImg) {
                fotoInput.addEventListener('change', function () {
                    const file = this.files && this.files[0] ? this.files[0] : null;

                    if (!file) {
                        fotoPreviewImg.src = '';
                        fotoPreviewWrap.classList.add('d-none');
                        return;
                    }

                    const objectUrl = URL.createObjectURL(file);
                    fotoPreviewImg.src = objectUrl;
                    fotoPreviewWrap.classList.remove('d-none');
                });
            }

            const deleteModal = document.getElementById('deletePengaduanModal');

            if (!deleteModal) {
                return;
            }

            const deleteTitle = document.getElementById('deletePengaduanTitle');
            const confirmDeleteBtn = document.getElementById('confirmDeletePengaduanBtn');
            const deleteForm = document.getElementById('deletePengaduanForm');
            let deleteActionUrl = '';

            deleteModal.addEventListener('show.bs.modal', function (event) {
                const deleteButton = event.relatedTarget;

                if (!deleteButton) {
                    return;
                }

                deleteActionUrl = deleteButton.getAttribute('data-delete-url') || '';
                deleteTitle.textContent = deleteButton.getAttribute('data-pengaduan-title') || 'ini';
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
