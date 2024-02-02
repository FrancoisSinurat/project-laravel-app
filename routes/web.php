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

Route::get('/admin', function () {
    return redirect('/admin/dashboard');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'as' => 'admin.'], function () {
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::resource('asset-category', App\Http\Controllers\AssetCategoryController::class);
    Route::resource('item-category', App\Http\Controllers\ItemCategoryController::class);
    Route::resource('item', App\Http\Controllers\ItemController::class);
    Route::resource('satuan-category', App\Http\Controllers\SatuanCategoryController::class);
    Route::resource('bahan-category', App\Http\Controllers\BahanCategoryController::class);
});
