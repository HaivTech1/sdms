<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\WhatsappController;
use App\Http\Controllers\Admin\ResultController;

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
            Route::get('/contacts', [WhatsappController::class, 'contacts'])->name('contacts');
            Route::post('/store/contact', [WhatsappController::class, 'storeContact'])->name('storeContact');
            Route::post('/create/multiple/contacts', [WhatsappController::class, 'createMultipleContacts'])->name('createMultipleContacts');
            Route::get('/merge/parent/contact/{type}', [WhatsappController::class, 'mergeParentContact'])->name('merge_contact');
            Route::get('/messages', [WhatsappController::class, 'messages'])->name('messages');
            Route::post('/send/message', [WhatsappController::class, 'sendMessage'])->name('sendMessage');
            Route::post('/send/multiple/message', [WhatsappController::class, 'sendMultipleMessage'])->name('sendMultipleMessage');
            Route::post('/schedule/message', [WhatsappController::class, 'scheduleMessage'])->name('scheduleMessage');
        });

        Route::group(['prefix' => 'result', 'as' => 'result.'], function () {
            Route::post('/multiple/exam/publish', [ResultController::class, 'multipleExamPublish'])->name('multipleExamPublish');
            Route::post('/multiple/midterm/publish', [ResultController::class, 'multipleMidtermPublish'])->name('multipleMidtermPublish');
        });

    });
});