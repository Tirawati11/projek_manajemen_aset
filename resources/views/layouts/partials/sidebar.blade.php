<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="index.html">Manajemen Aset</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">TK</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="{{ Request::Is('dashboard') ? 'active' : '' }}">
            <a href="{{ url('dashboard') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a>
        </li>
        <li class="menu-header">Aset</li>
        @if(Auth::check() && Auth::user()->jabatan == 'admin')
        <li class="dropdown {{ Request::routeIs('aset.*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Aset</span></a>
            <ul class="dropdown-menu">
                <li class="{{ Request::routeIs('aset.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('aset.index') }}">Inventaris</a></li>
                <li class="{{ Request::routeIs('peminjaman.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('peminjaman.index') }}">Peminjaman Aset</a></li>
                <li class="{{ Request::routeIs('pengajuan.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('pengajuan.index') }}">Pengajuan Aset</a></li>
            </ul>
        </li>
        @elseif(Auth::check() && Auth::user()->jabatan == 'karyawan')
        <li class="{{ Request::routeIs('peminjaman.index') ? 'active' : '' }}">
            <a href="{{ route('peminjaman.index') }}"><i class="fas fa-columns"></i> <span>Peminjaman Aset</span></a>
        </li>
        <li class="{{ Request::routeIs('pengajuan.index') ? 'active' : '' }}">
            <a href="{{ route('pengajuan.index') }}"><i class="fas fa-columns"></i> <span>Pengajuan Aset</span></a>
        </li>
        @endif
        @if(Auth::check() && Auth::user()->jabatan == 'admin')
        <li class="{{ Request::RouteIs('categories.index') ? 'active' : '' }}">
            <a href="{{ route('categories.index') }}"><i class="fas fa-th"></i> <span>Kategori</span></a>
        </li>
        @endif
        @if(Auth::check() && Auth::user()->jabatan == 'admin')
        <li class="{{ Request::Is('laporan') ? 'active' : '' }}">
            <a href="{{ url('laporan') }}"><i class="far fa-file-alt"></i> <span>Laporan</span></a>
        </li>
        @endif
        @if(Auth::check() && Auth::user()->jabatan == 'admin')
        <li class="{{ Request::RouteIs('lokasi.index') ? 'active' : '' }}">
            <a href="{{ route('lokasi.index') }}"><i class="fas fa-map-marker-alt"></i> <span>Lokasi</span></a>
        </li>
        @endif
        @if(Auth::check() && Auth::user()->jabatan == 'admin')
        <li class="menu-header">Konfigurasi</li>
        <li class="{{ Request::routeIs('users.index') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}" class="nav-link"><i class="far fa-user"></i> <span>User</span></a>
        </li>
        @endif
    </ul>
</aside>
</div>
