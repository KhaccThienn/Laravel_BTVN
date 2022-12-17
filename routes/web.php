<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Product\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(["prefix" => ''], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::prefix('category')->group(function () {
        Route::get('/recycle-bin', [CategoryController::class, 'recycle_bin'])->name('category.recycle_bin');
        Route::get('/recycle-bin/{id}', [CategoryController::class, 'restore'])->name('category.restore');
        Route::delete('/recycle-bin/{id}', [CategoryController::class, 'force_delete'])->name('category.force_delete');
    });
    Route::prefix('product')->group(function () {
        Route::get('/recycle-bin', [ProductController::class, 'recycle_bin'])->name('product.recycle_bin');
        Route::get('/recycle-bin/{id}', [ProductController::class, 'restore'])->name('product.restore');
        Route::delete('/recycle-bin/{id}', [ProductController::class, 'force_delete'])->name('product.force_delete');
    });
    Route::resources([
        'category' => CategoryController::class,
        'product' => ProductController::class
    ]);
});
