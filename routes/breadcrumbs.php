<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('admin.dashboard'));
});

// Dashboard > Item Category
Breadcrumbs::for('admin.item-category.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Kategori', route('admin.item-category.index'));
});

// Dashboard > User
Breadcrumbs::for('admin.user.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Pengguna', route('admin.user.index'));
});

// Dashboard > Role
Breadcrumbs::for('admin.role.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Hak Akses', route('admin.role.index'));
});

// Dashboard > Asal Pengadaan Category
Breadcrumbs::for('admin.asalpengadaan-category.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Asal Pengadaan', route('admin.asalpengadaan-category.index'));
});

// Dashboard > Satuan Category
Breadcrumbs::for('admin.satuan-category.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Satuan', route('admin.satuan-category.index'));
});

// Dashboard > Bahan Category
Breadcrumbs::for('admin.bahan-category.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Bahan', route('admin.bahan-category.index'));
});

// Dashboard > Asaloleh Category
Breadcrumbs::for('admin.asaloleh-category.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Asal Perolehan', route('admin.asaloleh-category.index'));
});

// Dashboard > Asaloleh Category
Breadcrumbs::for('admin.asset-category.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Jenis Asset', route('admin.asset-category.index'));
});

// Dashboard > Jenisbarang Category
Breadcrumbs::for('admin.item.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Jenis Barang', route('admin.item.index'));
});

// // Home > Item Category > [Category]
// Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $category) {
//     $trail->parent('blog');
//     $trail->push($category->title, route('category', $category));
// });

// Dashboard > Aset
Breadcrumbs::for('admin.asset.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Aset', route('admin.asset.index'));
});

// Dashboard > Peminjaman
Breadcrumbs::for('admin.peminjaman.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Peminjaman', route('admin.peminjaman.index'));
});

// Dashboard > Brand
Breadcrumbs::for('admin.brand.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Merk', route('admin.brand.index'));
});

// Dashboard > Item Type
Breadcrumbs::for('admin.item-type.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Tipe Barang', route('admin.item-type.index'));
});

// Dashboard > Lokasi
Breadcrumbs::for('admin.location.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Lokasi', route('admin.location.index'));
});
