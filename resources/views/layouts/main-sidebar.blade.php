<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Web Kasir</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="dropdown {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link"><i
                        class="fas fa-chart-line"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Kasir</li>
            <li class="dropdown">
                <a href="#" class="nav-link"><i class="fas fa-cash-register"></i><span>Kasir</span></a>
            </li>
            <li class="menu-header">Manajement</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-box"></i>
                    <span>Manajement Barang</span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('management-barang.kategori.index') }}" class="nav-link">Kategori</a></li>
                    <li><a href="#" class="nav-link">Harga Jual</a></li>
                    <li><a href="{{ route('management-barang.barang.index') }}" class="nav-link">Barang</a></li>
                    <li><a href="#" class="nav-link">Diskon Barang</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="nav-link has-dropdown" href="#"><i class="fas fa-user"></i>
                    <span>Manajement Pelanggan</span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('management-pelanggan.type-pelanggan.index') }}" class="nav-link">Type Pelanggan</a></li>
                    <li><a href="#" class="nav-link">Pelanggan</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-flag"></i>
                    <span>Laporan</span></a>
                <ul class="dropdown-menu">
                    <li><a href="" class="nav-link">Laporan Transaksi</a></li>
                    <li><a href="" class="nav-link">Laporan Stok Barang</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i>
                    <span>User Manajement</span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('user-management.user.index') }}" class="nav-link">User</a></li>
                    <li><a href="{{ route('user-management.role.index') }}" class="nav-link">Role</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
