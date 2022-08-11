<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TokenAuthController;
use App\Http\Controllers\API\v1\PostController;
use App\Http\Controllers\API\v1\AgentController;
use App\Http\Controllers\API\v1\BookingController;
use App\Http\Controllers\API\v1\ContestController;
use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\API\v1\PropertyController;
use App\Http\Controllers\OtherBrowserSessionsController;

Route::middleware('guest')->group(
  function () {
      $limiter = config('fortify.limiters.login');

      Route::post('/auth/token', [TokenAuthController::class, 'store'])->middleware(
          array_filter([$limiter ? 'throttle:' . $limiter : null])
      );
  }
);

Route::middleware('auth:sanctum')->group(
  function () {
      Route::delete('/auth/token', [TokenAuthController::class, 'destroy']);

      Route::get('/me', [UserController::class, 'me']);
      Route::get('/user/sessions', [OtherBrowserSessionsController::class, 'index']);
      Route::post('/user/sessions/purge', [OtherBrowserSessionsController::class, 'destroy']);

  }
);

Route::group(['prefix' => 'v1'], function () {
   
    //properties
    Route::apiResource('/properties', PropertyController::class);
    Route::post('/reviews', [PropertyController::class, 'review'])->name('reviews');

    //bookings
    Route::resource('/bookings', BookingController::class);

    //products
    Route::apiResource('/products', ProductController::class);

    //posts
    Route::apiResource('/posts', PostController::class);
    
     //contests
     Route::apiResource('/contests', ContestController::class);

    //agents
    Route::get('/agents/{user}', [AgentController::class, 'show'])->name('agents');

      //users
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

}); 