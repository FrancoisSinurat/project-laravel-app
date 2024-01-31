<style>
    .divider {
        width: 80%;
        margin: auto;
        opacity: .07;
    }
</style>

<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.dashboard')}}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#master-data-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Master Data</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="master-data-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li class="nav-heading">Master Barang</li>
                <li>
                    <a href="{{route('admin.item-category.index')}}">
                        <i class="bi bi-chevron-double-right"></i><span>Jenis Barang</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-chevron-double-right"></i><span>Barang</span>
                    </a>
                </li>
                <li>
                    <hr class="divider">
                </li>
                <li class="nav-heading">Master Data</li>
                <li>
                    <a href="#">
                        <i class="bi bi-chevron-double-right"></i><span>Asal Oleh </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-chevron-double-right"></i><span>Bidang</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-chevron-double-right"></i><span>Jenis Aset</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#aset-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-box-seam"></i><span>Aset</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="aset-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="#">
                        <i class="bi bi-chevron-double-right"></i><span>Perangkat IT</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-chevron-double-right"></i><span>Kendaraan </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-chevron-double-right"></i><span>Furnitur </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-chevron-double-right"></i><span>Tak Berwujud </span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#user-data-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person-circle"></i><span>Pengguna</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="user-data-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="#">
                        <i class="bi bi-chevron-double-right"></i><span>Daftar Pengguna</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-chevron-double-right"></i><span>Hak Akses</span>
                    </a>
                </li>
            </ul>
        </li>

    </ul>

</aside>
