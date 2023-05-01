<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\v1\UserResource;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TokenAuthController;
use App\Http\Controllers\API\v1\AgentController;
use App\Http\Controllers\API\v1\SettingController;
use App\Http\Controllers\API\v1\StudentController;
use App\Http\Controllers\OtherBrowserSessionsController;

Route::middleware('guest')->group(function () {
      $limiter = config('fortify.limiters.login');

      Route::post('/auth/login', [TokenAuthController::class, 'store'])->middleware(
          array_filter([$limiter ? 'throttle:' . $limiter : null])
      );
  }
);

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {

    //users
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return new UserResource($request->user());
    });

    Route::delete('/auth/token', [TokenAuthController::class, 'destroy']);
    Route::get('/me', [UserController::class, 'me']);
    Route::get('/user/sessions', [OtherBrowserSessionsController::class, 'index']);
    Route::post('/user/sessions/purge', [OtherBrowserSessionsController::class, 'destroy']);

    Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'settings', 'namespace' => 'Settings'], function () {
      Route::get('/', [SettingController::class, 'index']);
      Route::get('/grades/all', [SettingController::class, 'grade']);
      Route::get('/sessions/all', [SettingController::class, 'session']);
      Route::get('/terms/all', [SettingController::class, 'term']);
    });

    Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'student', 'namespace' => 'Student'], function () {
        Route::get('/all', [StudentController::class, 'index']);
        Route::get('/assign/grade/student', [StudentController::class, 'assignStudent']);
    });

    Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'attendance', 'namespace' => 'Attendance'], function () {
        Route::get('/all', [AttendanceController::class, 'index']);
        Route::get('/active', [AttendanceController::class, 'active']);
        Route::get('/inactive', [AttendanceController::class, 'inactive']);
        Route::post('/create', [AttendanceController::class, 'store']);
        Route::get('/single/{id}', [AttendanceController::class, 'single']);
        Route::get('/delete/{id}', [AttendanceController::class, 'delete']);
        Route::get('/student/{id}/delete/{attendance}', [AttendanceController::class, 'deleteStudent']);
        Route::post('/mark', [AttendanceController::class, 'mark_attendance']);
        Route::get('/stat', [AttendanceController::class, 'stat_search']);
    }); 

}); 