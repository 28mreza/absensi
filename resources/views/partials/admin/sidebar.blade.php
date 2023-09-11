<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="index.html"><img src="{{ asset('admin') }}/assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-item {{ request()->is('panel/dashboardadmin') ? 'active' : '' }}">
                    <a href="{{ url('panel/dashboardadmin', []) }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('karyawan', 'departemen', 'cabang') ? 'active' : '' }} has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Data Master</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item {{ request()->is('karyawan') ? 'active' : '' }}">
                            <a href="{{ url('karyawan', []) }}">Karyawan</a>
                        </li>
                        <li class="submenu-item {{ request()->is('departemen') ? 'active' : '' }}">
                            <a href="{{ url('departemen', []) }}">Departemen</a>
                        </li>
                        <li class="submenu-item {{ request()->is('cabang') ? 'active' : '' }}">
                            <a href="{{ url('cabang', []) }}">Kantor Cabang</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item {{ request()->is('absensi/izinsakit') ? 'active' : '' }}">
                    <a href="{{ url('absensi/izinsakit') }}" class='sidebar-link'>
                        <i class="bi bi-display"></i>
                        <span>Data Izin/Sakit</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('absensi/monitoring') ? 'active' : '' }}">
                    <a href="{{ url('absensi/monitoring', []) }}" class='sidebar-link'>
                        <i class="bi bi-display"></i>
                        <span>Monitoring Absensi</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('absensi/laporan','absensi/rekap') ? 'active' : '' }} has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-clipboard"></i>
                        <span>Laporan</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item {{ request()->is('absensi/laporan') ? 'active' : '' }}">
                            <a href="{{ url('absensi/laporan', []) }}">Absensi</a>
                        </li>
                        <li class="submenu-item {{ request()->is('absensi/rekap') ? 'active' : '' }}">
                            <a href="{{ url('absensi/rekap', []) }}">Rekap Absensi</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item {{ request()->is('konfigurasi/lokasikantor') ? 'active' : '' }} has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-gear"></i>
                        <span>Konfigurasi</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item {{ request()->is('konfigurasi/lokasikantor') ? 'show' : '' }}">
                            <a href="{{ url('konfigurasi/lokasikantor') }}">Lokasi Kantor</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>