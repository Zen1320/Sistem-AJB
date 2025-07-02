<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset('panel/assets/img/logo.jpg')}}" alt="Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">E-AJB</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Menu</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-palette"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Untuk Pengguna (Role 2) --}}
                @if(Auth::user()->role == 2)
                    <li class="nav-item">
                        <a href="{{ route('pengguna.pembuatanajb.index') }}" class="nav-link {{ request()->routeIs('pengguna.pembuatanajb.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-signature"></i>
                            <p>Pembuatan AJB</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pengguna.daftar.index') }}" class="nav-link {{ request()->is('Daftar_AJB*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Riwayat Pengajuan</p>
                        </a>
                    </li>
                @endif

                {{-- Untuk Staff & Superadmin (Role 0 dan 1) --}}
                @if(Auth::user()->role == 0 || Auth::user()->role == 1)
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('Manajemen_PengajuanAJB*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>Manajemen Pengajuan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('Kelola_Laporan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan Pengajuan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('Kelola_Anggota.index')}}" class="nav-link {{ request()->is('Kelola_Anggota*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Kelola Anggota</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('Kelola_Masyarakat.index')}}" class="nav-link {{ request()->is('Kelola_Masyarakat*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-friends"></i>
                            <p>Kelola Masyarakat</p>
                        </a>
                    </li>
                @endif

                {{-- Untuk Superadmin (Role 0) --}}
                @if(Auth::user()->role == 0)
                    <li class="nav-header">Master Data</li>

                    <li class="nav-item">
                        <a href="{{ route('Kelola_Pengguna.index') }}" class="nav-link {{ request()->is('Kelola_Pengguna*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>Kelola Pengguna</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('Kelola_JenisTransaksi.index') }}" class="nav-link {{ request()->is('Kelola_JenisTransaksi*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>Jenis Transaksi</p>
                        </a>
                    </li>
                @endif

            </ul>
        </nav>
    </div>
</aside>
