@push('styles')
<style>
    .divider {
        width: 80%;
        margin: auto;
        opacity: .07;
    }
</style>
@endpush

<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{Route::current()->getName() == 'admin.dashboard' ? 'collapse' : 'collapsed'}}" href="{{route('admin.dashboard')}}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        @if(auth()->user()->hasPermissionTo('kategori-barang-list') ||
            auth()->user()->hasPermissionTo('barang-list') ||
            auth()->user()->hasPermissionTo('asal-oleh-list') ||
            auth()->user()->hasPermissionTo('asal-pengadaan-list') ||
            auth()->user()->hasPermissionTo('asset-group-list') ||
            auth()->user()->hasPermissionTo('jenis-aset-list') ||
            auth()->user()->hasPermissionTo('bahan-list') ||
            auth()->user()->hasPermissionTo('brand-list') ||
            auth()->user()->hasPermissionTo('tipe-list') ||
            auth()->user()->hasPermissionTo('lokasi-list') ||
            auth()->user()->hasPermissionTo('satuan-list'))
        <li class="nav-item">
            <a class="nav-link {{in_array(Route::current()->getName(), ['admin.item-category.index', 'admin.asaloleh-category.index', 'admin.asalpengadaan-category.index','admin.asset-group.index', 'admin.satuan-category.index', 'admin.bahan-category.index', 'admin.item-type.index',  'admin.brand.index', 'admin.location.index', 'admin.asset-category.index']) ? '' : 'collapsed'}}" data-bs-target="#master-data-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Master Data</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="master-data-nav"
                class="nav-content collapse {{in_array(Route::current()->getName(), ['admin.item-category.index', 'admin.asaloleh-category.index', 'admin.asalpengadaan-category.index','admin.asset-group.index', 'admin.satuan-category.index', 'admin.bahan-category.index', 'admin.item.index', 'admin.item-type.index',  'admin.brand.index', 'admin.location.index', 'admin.asset-category.index']) ? 'show' : ''}}"
                data-bs-parent="#sidebar-nav">
                @if(auth()->user()->hasPermissionTo('kategori-barang-list') || auth()->user()->hasPermissionTo('barang-list'))
                    <li class="nav-heading">Master Barang</li>
                    @if(auth()->user()->hasPermissionTo('kategori-barang-list'))
                    <li>
                        <a href="{{route('admin.item-category.index')}}" class="{{Route::current()->getName() == 'admin.item-category.index' ? 'active' : ''}}">
                            <i class="bi bi-chevron-double-right"></i><span>Kategori</span>
                        </a>
                    </li>
                    @endif
                    @if(auth()->user()->hasPermissionTo('barang-list'))
                    <li>
                    <a href="{{route('admin.item.index')}}" class="{{Route::current()->getName() == 'admin.item.index' ? 'active' : ''}}">
                            <i class="bi bi-chevron-double-right"></i><span>Jenis Barang</span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <hr class="divider">
                    </li>
                    @endif
                @endif
                @if(auth()->user()->hasPermissionTo('asal-oleh-list') ||
                    auth()->user()->hasPermissionTo('jenis-aset-list') ||
                    auth()->user()->hasPermissionTo('asal-pengadaan-list') ||
                    auth()->user()->hasPermissionTo('asset-group-list') ||
                    auth()->user()->hasPermissionTo('lokasi-list') ||
                    auth()->user()->hasPermissionTo('brand-list') ||
                    auth()->user()->hasPermissionTo('tipe-list') ||
                    auth()->user()->hasPermissionTo('bahan-list')
                    )
                <li class="nav-heading">Master Data</li>
                @if(auth()->user()->hasPermissionTo('asal-oleh-list'))
                <li>
                    <a href="{{route('admin.asaloleh-category.index')}}" class="{{Route::current()->getName() == 'admin.asaloleh-category.index' ? 'active' : ''}}">
                        <i class="bi bi-chevron-double-right"></i><span>Asal Perolehan</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->hasPermissionTo('asal-pengadaan-list'))
                <li>
                    <a href="{{route('admin.asalpengadaan-category.index')}}" class="{{Route::current()->getName() == 'admin.asalpengadaan-category.index' ? 'active' : ''}}">
                        <i class="bi bi-chevron-double-right"></i><span>Asal Pengadaan</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->hasPermissionTo('asset-group-list'))
                <li>
                    <a href="{{route('admin.asset-group.index')}}" class="{{Route::current()->getName() == 'admin.asset-group.index' ? 'active' : ''}}">
                        <i class="bi bi-chevron-double-right"></i><span>Aset Group</span>
                    </a>
                </li>
                @endif
               
                @if(auth()->user()->hasPermissionTo('jenis-aset-list'))
                <li>
                    <a href="{{route('admin.asset-category.index')}}" class="{{Route::current()->getName() == 'admin.asset-category.index' ? 'active' : ''}}">
                        <i class="bi bi-chevron-double-right"></i><span>Jenis Aset</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->hasPermissionTo('lokasi-list'))
                <li>
                    <a href="{{route('admin.location.index')}}" class="{{Route::current()->getName() == 'admin.location.index' ? 'active' : ''}}">
                        <i class="bi bi-chevron-double-right"></i><span>Lokasi</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->hasPermissionTo('satuan-list'))
                <li>
                    <a href="{{route('admin.satuan-category.index')}}" class="{{Route::current()->getName() == 'admin.satuan-category.index' ? 'active' : ''}}">
                        <i class="bi bi-chevron-double-right"></i><span>Satuan</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->hasPermissionTo('bahan-list'))
                <li>
                    <a href="{{route('admin.bahan-category.index')}}" class="{{Route::current()->getName() == 'admin.bahan-category.index' ? 'active' : ''}}">
                        <i class="bi bi-chevron-double-right"></i><span>Bahan</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->hasPermissionTo('brand-list'))
                <li>
                    <a href="{{route('admin.brand.index')}}" class="{{Route::current()->getName() == 'admin.brand.index' ? 'active' : ''}}">
                        <i class="bi bi-chevron-double-right"></i><span>Merk</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->hasPermissionTo('tipe-list'))
                <li>
                    <a href="{{route('admin.item-type.index')}}" class="{{Route::current()->getName() == 'admin.item-type.index' ? 'active' : ''}}">
                        <i class="bi bi-chevron-double-right"></i><span>Tipe</span>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        @if(auth()->user()->hasPermissionTo('aset-list') ||
            auth()->user()->hasPermissionTo('aset-peminjaman-list'))
        <li class="nav-item">
            <a class="nav-link {{in_array(Route::current()->getName(), ['admin.asset.index', 'admin.peminjaman.index']) ? '' : 'collapsed'}}" data-bs-target="#asset-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-box-seam"></i><span>Transaksi</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="asset-nav" class="nav-content collapse {{in_array(Route::current()->getName(), ['admin.asset.index', 'admin.peminjaman.index']) ? 'show' : ''}}" data-bs-parent="#sidebar-nav">
                @if(auth()->user()->hasPermissionTo('aset-list'))
                <li>
                    <a href="{{route('admin.asset.index')}}" class="{{Route::current()->getName() == 'admin.asset.index' ? 'active' : ''}}">
                        <i class="bi bi-chevron-double-right"></i><span>Aset</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->hasPermissionTo('aset-peminjaman-list'))
                <li>
                    <a href="{{route('admin.peminjaman.index')}}" class="{{Route::current()->getName() == 'admin.peminjaman.index' ? 'active' : ''}}">
                        <i class="bi bi-chevron-double-right"></i><span>Peminjaman</span>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        @if(auth()->user()->hasPermissionTo('user-list') ||
            auth()->user()->hasPermissionTo('role-list')
        )
        <li class="nav-item">
            <a class="nav-link {{in_array(Route::current()->getName(), ['admin.user.index', 'admin.role.index']) ? '' : 'collapsed'}}" data-bs-target="#user-data-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person-circle"></i><span>Pengguna</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="user-data-nav" class="nav-content collapse {{in_array(Route::current()->getName(), ['admin.user.index', 'admin.role.index']) ? 'show' : ''}}" data-bs-parent="#sidebar-nav">
                @if(auth()->user()->hasPermissionTo('user-list'))
                <li>
                    <a href="{{route('admin.user.index')}}" class="{{Route::current()->getName() == 'admin.user.index' ? 'active' : ''}}">
                        <i class="bi bi-chevron-double-right"></i><span>Pengguna</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->hasPermissionTo('role-list'))
                <li>
                    <a href="{{route('admin.role.index')}}" class="{{Route::current()->getName() == 'admin.role.index' ? 'active' : ''}}">
                        <i class="bi bi-chevron-double-right"></i><span>Hak Akses</span>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif

    </ul>

</aside>
