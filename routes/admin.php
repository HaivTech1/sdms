<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\WhatsappController;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::group(['namespace' => 'Admin', 'as' => 'admin.'], function () {

        Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
        });

        Route::group(['prefix' => 'gallery', 'as' => 'gallery.'], function () {
            Route::get('/', [GalleryController::class, 'index'])->name('index');
            Route::post('/', [GalleryController::class, 'store'])->name('store');
            Route::delete('/delete/{gallery}', [GalleryController::class, 'destroy'])->name('delete');
            Route::post('/multple/delete', [GalleryController::class, 'destroyMany'])->name('deleteMany');
        });

        Route::group(['prefix' => 'about', 'as' => 'about.'], function () {
            Route::get('/', [AboutController::class, 'index'])->name('index');
            Route::post('/', [AboutController::class, 'store'])->name('store');
            Route::delete('/delete/{about}', [AboutController::class, 'destroy'])->name('delete');
            Route::post('/multple/delete', [AboutController::class, 'destroyMany'])->name('deleteMany');
            Route::post('/update', [AboutController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'whatsapp', 'as' => 'whatsapp.'], function () {
            Route::get('/', [WhatsappController::class, 'contacts'])->name('contacts');
        });

    });
});