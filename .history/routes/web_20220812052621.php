<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ContestantController;
use App\Http\Controllers\ApplicationController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['prefix' => 'property', 'as' => 'property.'], function () {
        Route::get('/', [PropertyController::class, 'index'])->name('index');
        Route::post('/', [PropertyController::class, 'store'])->name('store');
        Route::get('show/{property}', [PropertyController::class, 'show'])->name('show');
        Route::get('edit/{property}', [PropertyController::class, 'edit'])->name('edit');
        Route::get('create', [PropertyController::class, 'create'])->name('create');
        Route::put('/{property}', [PropertyController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'booking', 'as' => 'booking.'], function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::post('/', [BookingController::class, 'store'])->name('store');
        Route::get('show/{booking}', [BookingController::class, 'show'])->name('show');
        Route::get('edit/{booking}', [BookingController::class, 'edit'])->name('edit');
        Route::get('create', [BookingController::class, 'create'])->name('create');
        Route::put('/{booking}', [BookingController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('show/{product}', [ProductController::class, 'show'])->name('show');
        Route::get('edit/{product}', [ProductController::class, 'edit'])->name('edit');
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'post', 'as' => 'post.'], function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::get('show/{post}', [PostController::class, 'show'])->name('show');
        Route::get('edit/{post}', [PostController::class, 'edit'])->name('edit');
        Route::get('create', [PostController::class, 'create'])->name('create');
        Route::put('/{post}', [PostController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('show/{user}', [UserController::class, 'show'])->name('show');
        Route::get('edit/{user}', [UserController::class, 'edit'])->name('edit');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
    });
    
    Route::group(['prefix' => 'order', 'as' => 'order.'], function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
    });

    Route::resource('task',TaskController::class);
    Route::resource('contest',ContestController::class);

    Route::resource('setting',ApplicationController::class);

    Route::group(['prefix' => 'contestant', 'as' => 'contestant.'], function () {
        Route::get('/', [ContestantController::class, 'index'])->name('index');
        Route::post('/', [ContestantController::class, 'store'])->name('store');
        Route::get('show/{contestant}', [ContestantController::class, 'show'])->name('show');
        Route::get('edit/{contestant}', [ContestantController::class, 'edit'])->name('edit');
        Route::get('create', [ContestantController::class, 'create'])->name('create');
        Route::put('/{contestant}', [ContestantController::class, 'update'])->name('update');
    });

    Route::resource('period',PeriodController::class);
    Route::resource('grade',GradeController::class);
    Route::resource('subject',SubjectController::class);
    Route::resource('student',StudentController::class);
    Route::resource('term',TermController::class);
    Route::resource('result',ResultController::class);
    Route::get('/singleUpload/result', [ResultController::class, 'singleUpload'])->name('result.singleUpload');
    Route::post('/Upload/result', [ResultController::class, 'singleUpload'])->name('result.Upload');
});

/**
 * Teamwork routes
 */
Route::group(['prefix' => 'teams', 'namespace' => 'Teamwork'], function()
{
    Route::get('/', [App\Http\Controllers\Teamwork\TeamController::class, 'index'])->name('teams.index');
    Route::get('create', [App\Http\Controllers\Teamwork\TeamController::class, 'create'])->name('teams.create');
    Route::post('teams', [App\Http\Controllers\Teamwork\TeamController::class, 'store'])->name('teams.store');
    Route::get('edit/{id}', [App\Http\Controllers\Teamwork\TeamController::class, 'edit'])->name('teams.edit');
    Route::put('edit/{id}', [App\Http\Controllers\Teamwork\TeamController::class, 'update'])->name('teams.update');
    Route::delete('destroy/{id}', [App\Http\Controllers\Teamwork\TeamController::class, 'destroy'])->name('teams.destroy');
    Route::get('switch/{id}', [App\Http\Controllers\Teamwork\TeamController::class, 'switchTeam'])->name('teams.switch');

    Route::get('members/{id}', [App\Http\Controllers\Teamwork\TeamMemberController::class, 'show'])->name('teams.members.show');
    Route::get('members/resend/{invite_id}', [App\Http\Controllers\Teamwork\TeamMemberController::class, 'resendInvite'])->name('teams.members.resend_invite');
    Route::post('members/{id}', [App\Http\Controllers\Teamwork\TeamMemberController::class, 'invite'])->name('teams.members.invite');
    Route::delete('members/{id}/{user_id}', [App\Http\Controllers\Teamwork\TeamMemberController::class, 'destroy'])->name('teams.members.destroy');

    Route::get('accept/{token}', [App\Http\Controllers\Teamwork\AuthController::class, 'acceptInvite'])->name('teams.accept_invite');
});