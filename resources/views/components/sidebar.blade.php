<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
        <a class="nav-link" href="{{ url('home') }}">Sahabat E-BIKE</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">SE</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('home') }}"><i class="fas fa-columns"></i> <span>Dashboard</span></a>
            </li>
            <li class="menu-header">Kelola User</li>
            <li class="{{ Request::is('admin/user/list') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/user/list') }}"><i class="fas fa-user"></i> <span>Kelola
                        User</span></a>
            </li>
            <li class="menu-header">Kelola Sepeda</li>
            <li class="{{ Request::is('admin/tipeSepeda/list') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/tipeSepeda/list') }}"><i class="fas fa-book"></i> <span>Tipe
                        Sepeda</span></a>
            </li>
            <li class="{{ Request::is('admin/durasiSewa/list') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/durasiSewa/list') }}"><i class="fas fa-clock"></i>
                    <span>Durasi
                        Sewa</span></a>
            </li>
            <li class="{{ Request::is('admin/sepeda/list') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/sepeda/list') }}"><i class="fas fa-bicycle"></i>
                    <span>Sepeda</span></a>
            </li>
            <li class="menu-header">Kelola Transaksi</li>
            <li class="{{ Request::is('admin/transaksi/list') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/transaksi/list') }}"><i class="far fa-file-alt"></i>
                    <span>Kelola
                        Transaksi</span></a>
            </li>
            <li class="menu-header">Report</li>
            <li class="{{ Request::is('admin/laporan/list') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/laporan/list') }}"><i class="far fa-paste"></i>
                    <span>Laporan</span></a>
            </li>
        </ul>

        <!-- <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div> -->
    </aside>
</div>
