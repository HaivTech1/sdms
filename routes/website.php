<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;

Route::get('/storage-link', function () {
    $targetFolder = storage_path('app/public');
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    symlink($targetFolder, $linkFolder);
});

Route::get('/', [HomeController::class, 'index']);

Route::get('/about', [HomeController::class, 'about']);
Route::get('/gallery', [HomeController::class, 'gallery']);
Route::get('/shop', [HomeController::class, 'shop']);
Route::get('/cart', [HomeController::class, 'cart']);
Route::get('/checkout', [HomeController::class, 'checkout']);
Route::get('/registration', [HomeController::class, 'registration']);