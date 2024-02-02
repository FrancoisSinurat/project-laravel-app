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
    $trail->push('Jenis Barang', route('admin.item-category.index'));
});

<<<<<<< HEAD
// Dashboard > Bidang Category
Breadcrumbs::for('admin.bidang-category.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Bahan', route('admin.bidang-category.index'));
=======
// Dashboard > Satuan Category
Breadcrumbs::for('admin.satuan-category.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Satuan', route('admin.satuan-category.index'));
});

// Dashboard > Bahan Category
Breadcrumbs::for('admin.bahan-category.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Bahan', route('admin.bahan-category.index'));
>>>>>>> f1212646ed25f5c37e5d9c7bd17f296dc33664c6
});

// // Home > Item Category > [Category]
// Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $category) {
//     $trail->parent('blog');
//     $trail->push($category->title, route('category', $category));
// });
