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

// Dashboard > Bidang Category
Breadcrumbs::for('admin.bidang-category.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Bahan', route('admin.bidang-category.index'));
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

// // Home > Item Category > [Category]
// Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $category) {
//     $trail->parent('blog');
//     $trail->push($category->title, route('category', $category));
// });
