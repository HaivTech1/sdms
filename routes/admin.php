<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;

Route::group(['namespace' => 'Admin', 'as' => 'admin.', 'middleware' => ['admin', 'auth']], function () {

    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
    });
});