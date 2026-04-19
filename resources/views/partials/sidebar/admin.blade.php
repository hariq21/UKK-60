@php
    $isAdminDashboard = request()->routeIs('admin.dashboard');
    $isAdminKategori = request()->routeIs('admin.kategori.*');
    $isAdminSiswa = request()->routeIs('admin.siswa.*');
    $isAdminPengaduan = request()->routeIs('admin.pengaduan.*');
    $isAdminProfile = request()->routeIs('admin.profile');
@endphp

<aside class="col-12 col-lg-3 col-xl-2 bg-white admin-sidebar-shell">
    <div class="d-flex flex-column py-4 px-3 position-sticky top-0 vh-100 overflow-auto">
        <div class="d-flex align-items-center gap-2 mb-4 admin-sidebar-profile">
            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light text-secondary admin-sidebar-avatar" style="width: 38px; height: 38px;">
                <i class="bi bi-person"></i>
            </span>
            <div class="min-w-0">
                <h6 class="mb-0 fw-semibold text-truncate">{{ Auth::user()->name }}</h6>
                <small class="text-muted">Administrator</small>
            </div>
        </div>

        <p class="text-uppercase text-secondary fw-semibold small mb-2">Menu</p>
        <div class="list-group list-group-flush mb-3">
            <a class="list-group-item list-group-item-action border-0 rounded-2 px-3 py-2 mb-1 d-flex align-items-center gap-2 sidebar-admin-link {{ $isAdminDashboard ? 'sidebar-admin-link--active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            <a class="list-group-item list-group-item-action border-0 rounded-2 px-3 py-2 mb-1 d-flex align-items-center gap-2 sidebar-admin-link {{ $isAdminKategori ? 'sidebar-admin-link--active' : '' }}" href="{{ route('admin.kategori.index') }}">
                <i class="bi bi-tags"></i>
                <span>Kategori</span>
            </a>
            <a class="list-group-item list-group-item-action border-0 rounded-2 px-3 py-2 mb-1 d-flex align-items-center gap-2 sidebar-admin-link {{ $isAdminSiswa ? 'sidebar-admin-link--active' : '' }}" href="{{ route('admin.siswa.create') }}">
                <i class="bi bi-person-plus"></i>
                <span>Siswa</span>
            </a>
            <a class="list-group-item list-group-item-action border-0 rounded-2 px-3 py-2 mb-1 d-flex align-items-center gap-2 sidebar-admin-link {{ $isAdminPengaduan ? 'sidebar-admin-link--active' : '' }}" href="{{ route('admin.pengaduan.index') }}">
                <i class="bi bi-chat-left-text"></i>
                <span>Pengaduan</span>
            </a>
            <a class="list-group-item list-group-item-action border-0 rounded-2 px-3 py-2 mb-1 d-flex align-items-center gap-2 sidebar-admin-link {{ $isAdminProfile ? 'sidebar-admin-link--active' : '' }}" href="{{ route('admin.profile') }}">
                <i class="bi bi-person-circle"></i>
                <span>Profil</span>
            </a>
        </div>

        <div class="mt-auto pt-3 admin-sidebar-logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-light border w-100 text-danger d-flex align-items-center justify-content-center gap-2" type="submit">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
