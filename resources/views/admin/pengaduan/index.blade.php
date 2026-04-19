<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">
    <div class="container-fluid px-0">
        <div class="row g-0 min-vh-100">
            @include('partials.sidebar.admin')

            <main class="col p-3 p-md-4">
                <div class="mb-4">
                    <h1 class="h3 mb-1">Pengaduan</h1>
                    <p class="text-muted mb-0">Kelola laporan siswa dengan tampilan dashboard yang clean.</p>
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
                    </div>
                    <div class="table-responsive px-3 pb-3 kategori-table-wrap">
                        <table class="table table-hover align-middle mb-0 js-datatable kategori-table">
                            <thead class="small text-secondary">
                                <tr>
                                    <th class="fw-semibold py-2" style="width: 72px;">No</th>
                                    <th class="fw-semibold py-2" style="width: 100px;">ID</th>
                                    <th class="fw-semibold py-2">Nama Siswa</th>
                                    <th class="fw-semibold py-2 text-start" style="width: 160px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @forelse ($pengaduans as $pengaduan)
                                    <tr>
                                        <td class="text-secondary">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                                        <td><span class="badge text-bg-light border">#{{ $pengaduan->id }}</span></td>
                                        <td>{{ $pengaduan->user?->name ?? '-' }}</td>
                                        <td class="text-start">
                                            <div class="d-inline-flex justify-content-start align-items-center gap-1 w-100">
                                                <a
                                                    href="{{ route('admin.pengaduan.show', ['pengaduan' => $pengaduan, 'mode' => 'view']) }}"
                                                    class="btn btn-sm btn-light border btn-icon-action"
                                                    title="View"
                                                >
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a
                                                    href="{{ route('admin.pengaduan.show', ['pengaduan' => $pengaduan, 'mode' => 'edit']) }}"
                                                    class="btn btn-sm btn-light border btn-icon-action"
                                                    title="Edit"
                                                >
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-light border text-danger btn-icon-action js-delete-pengaduan-trigger"
                                                    title="Hapus"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deletePengaduanModal"
                                                    data-delete-url="{{ route('admin.pengaduan.destroy', $pengaduan) }}"
                                                    data-pengaduan-name="{{ $pengaduan->user?->name ?? ('#' . $pengaduan->id) }}"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-5">
                                            <i class="bi bi-inbox d-block mb-2 fs-4"></i>
                                            Belum ada pengaduan masuk.
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

    <div class="modal fade" id="deletePengaduanModal" tabindex="-1" aria-labelledby="deletePengaduanLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header border-0 pb-0">
                    <h3 class="h5 modal-title" id="deletePengaduanLabel">Hapus Pengaduan</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="mb-0">
                        Apakah Kamu Yakin ingin menghapus pengaduan dari
                        <span id="deletePengaduanName" class="fw-semibold"></span>?
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
            const deleteModal = document.getElementById('deletePengaduanModal');

            if (!deleteModal) {
                return;
            }

            const deleteName = document.getElementById('deletePengaduanName');
            const confirmDeleteBtn = document.getElementById('confirmDeletePengaduanBtn');
            const deleteForm = document.getElementById('deletePengaduanForm');
            let deleteActionUrl = '';

            deleteModal.addEventListener('show.bs.modal', function (event) {
                const deleteButton = event.relatedTarget;

                if (!deleteButton) {
                    return;
                }

                deleteActionUrl = deleteButton.getAttribute('data-delete-url') || '';
                deleteName.textContent = deleteButton.getAttribute('data-pengaduan-name') || 'siswa ini';
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
