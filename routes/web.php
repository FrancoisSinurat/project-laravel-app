<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return redirect('/admin/dashboard');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'as' => 'admin.'], function () {
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::resource('asaloleh-category', App\Http\Controllers\AsalolehCategoryController::class);
    Route::resource('asset-category', App\Http\Controllers\AssetCategoryController::class);
    Route::resource('asset', App\Http\Controllers\AssetController::class);
    Route::resource('peminjaman', App\Http\Controllers\PeminjamanController::class);
    Route::resource('bahan-category', App\Http\Controllers\BahanCategoryController::class);
    Route::resource('asalpengadaan-category', App\Http\Controllers\AsalpengadaanCategoryController::class);
    Route::resource('asset-group', App\Http\Controllers\AssetGroupController::class);
    Route::resource('item-category', App\Http\Controllers\ItemCategoryController::class);
    Route::resource('item', App\Http\Controllers\ItemController::class);
    Route::resource('satuan-category', App\Http\Controllers\SatuanCategoryController::class);
    Route::resource('brand', App\Http\Controllers\ItemBrandController::class);
    Route::resource('item-type', App\Http\Controllers\ItemTypeController::class);
    Route::resource('location', App\Http\Controllers\LocationController::class);
    Route::resource('asset-temporary', App\Http\Controllers\AssetTemporaryController::class);

    Route::resource('user', App\Http\Controllers\UserController::class);
    Route::resource('role', App\Http\Controllers\RoleController::class);

    // ajax
    Route::get('/asset-ajax', [App\Http\Controllers\AssetController::class, 'ajax'])->name('asset.ajax');
    Route::get('/asset-category-ajax', [App\Http\Controllers\AssetCategoryController::class, 'ajax'])->name('asset-category.ajax');
    Route::get('/item-category-ajax', [App\Http\Controllers\ItemCategoryController::class, 'ajax'])->name('item-category.ajax');
    Route::get('/item-ajax', [App\Http\Controllers\ItemController::class, 'ajax'])->name('item.ajax');
    Route::get('/brand-ajax', [App\Http\Controllers\ItemBrandController::class, 'ajax'])->name('brand.ajax');
    Route::get('/type-ajax', [App\Http\Controllers\ItemTypeController::class, 'ajax'])->name('type.ajax');
    Route::get('/asaloleh-ajax', [App\Http\Controllers\AsalolehCategoryController::class, 'ajax'])->name('asaloleh.ajax');
    Route::get('/asalpendadaan-ajax', [App\Http\Controllers\AsalpengadaanCategoryController::class, 'ajax'])->name('asalpengadaan.ajax');
    Route::get('/asset-group-ajax', [App\Http\Controllers\AssetGroupController::class, 'ajax'])->name('asset-group.ajax');
    Route::get('/bahan-ajax', [App\Http\Controllers\BahanCategoryController::class, 'ajax'])->name('bahan.ajax');
    Route::get('/satuan-ajax', [App\Http\Controllers\SatuanCategoryController::class, 'ajax'])->name('satuan.ajax');
    Route::get('/user-ajax', [App\Http\Controllers\UserController::class, 'ajax'])->name('user.ajax');
    Route::get('/location-ajax', [App\Http\Controllers\LocationController::class, 'ajax'])->name('location.ajax');
    Route::get('/asset-group-ajax', [App\Http\Controllers\AssetGroupController::class, 'ajax'])->name('asset-group.ajax');
    Route::delete('/asset-temporary-delete', [App\Http\Controllers\AssetTemporaryController::class, 'destroyAll'])->name('asset-temporary-delete.destroyAll');
    Route::post('/upload', [App\Http\Controllers\MediaController::class, 'uploadSingleFile'])->name('upload-file');
    Route::get('card-ajax', [App\Http\Controllers\HomeController::class, 'ajax'])->name('card.ajax');
});
// public
Route::get('/upload/{doc}', [App\Http\Controllers\MediaController::class, 'getSingleFile'])->name('get-file');
