<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard.dashboard') }}">Web Kasir</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard.dashboard') }}">WK</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="dropdown {{ request()->routeIs('dashboard.dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard.dashboard') }}" class="nav-link"><i
                        class="fas fa-chart-line"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Kasir</li>
            <li class="dropdown {{ request()->routeIs('kasir.index') ? 'active' : '' }}">
                <a href="{{ route('kasir.index') }}" class="nav-link"><i
                        class="fas fa-cash-register"></i><span>Kasir</span></a>
            </li>
            @if(Auth::check() && Auth::user()->role->role == 'Administrator')
                <li class="menu-header">List Data</li>
                <li class="dropdown {{ request()->routeIs('list-data.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-list"></i>
                        <span>List Data </span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('list-data.kategori.index') }}"
                                class="nav-link {{ request()->routeIs('list-data.kategori.*') ? 'text-primary' : '' }}">Kategori</a>
                        </li>
                        <li><a href="{{ route('list-data.diskon.index') }}"
                                class="nav-link {{ request()->routeIs('list-data.diskon.*') ? 'text-primary' : '' }}">Diskon
                                Barang</a></li>
                    </ul>
                </li>
                <li class="menu-header">Manajement</li>
                <li class="dropdown {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                    <a href="{{ route('barang.index') }}" class="nav-link"><i class="fas fa-box"></i><span>Barang</span></a>
                </li>
                <li class="dropdown {{ request()->routeIs('pelanggan.index') ? 'active' : '' }}">
                    <a href="{{ route('pelanggan.index') }}" class="nav-link"><i
                            class="fas fa-user"></i><span>Pelanggan</span></a>
                </li>
            @endif
            <li class="dropdown {{ request()->routeIs('laporan-transaksi.index') ? 'active' : '' }}">
                <a href="{{ route('laporan-transaksi.index') }}" class="nav-link"><i
                        class="fas fa-flag"></i><span>Laporan Transaksi</span></a>
            </li>
            @if(Auth::check() && Auth::user()->role->role == 'Administrator')
                <li class="dropdown {{ request()->routeIs('user-management.user.index') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i>
                        <span>User Manajement</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('user-management.user.index') }}"
                                class="nav-link {{ request()->routeIs('user-management.user.*') ? 'text-primary' : '' }}">User</a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </aside>
</div>
