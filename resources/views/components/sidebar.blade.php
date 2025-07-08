<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a class="nav-link" href="{{ url('home') }}">RSPB</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">SE</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('home') }}"><i class="fas fa-columns"></i> <span>Dashboard</span></a>
            </li>
            <li class="menu-header">Kelola Driver</li>
            <li class="{{ Request::is('admin/drivers/list') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/drivers/list') }}"><i class="fas fa-user"></i> <span>Kelola
                        Driver</span></a>
            </li>
            <li class="menu-header">Kelola Rutes</li>
            <li class="{{ Request::is('admin/rutes/list') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/rutes/list') }}"><i class="fas fa-book"></i> <span>Kelola
                        Rutes</span></a>
            </li>
            <li class="menu-header">Kelola Transaksi</li>
            <li class="{{ Request::is('admin/transactions/list') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/transactions/list') }}"><i class="far fa-file-alt"></i>
                    <span>Kelola
                        Transaksi</span></a>
            </li>
            <li class="menu-header">Report</li>
            <li class="{{ Request::is('admin/report/list') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/report/list') }}"><i class="far fa-paste"></i>
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
