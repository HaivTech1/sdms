<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\v1\UserResource;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TokenAuthController;
use App\Http\Controllers\API\v1\AgentController;
use App\Http\Controllers\API\v1\StaffController;
use App\Http\Controllers\API\v1\ResultController;
use App\Http\Controllers\API\v1\SettingController;
use App\Http\Controllers\API\v1\StudentController;
use App\Http\Controllers\API\v1\AttendanceController;
use App\Http\Controllers\API\v1\RegistrationController;
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
    Route::get('/assigned/grades', [UserController::class, 'assignedGrade']);
    Route::get('/user/sessions', [OtherBrowserSessionsController::class, 'index']);
    Route::post('/user/sessions/purge', [OtherBrowserSessionsController::class, 'destroy']);

    Route::group(['prefix' => 'settings', 'namespace' => 'Settings'], function () {
      Route::get('/', [SettingController::class, 'index']);
      Route::get('/levels/all', [SettingController::class, 'grade']);
      Route::get('/sessions/all', [SettingController::class, 'session']);
      Route::get('/terms/all', [SettingController::class, 'term']);
      Route::get('/subjects/all', [SettingController::class, 'subject']);
      Route::get('/midterm/format', [SettingController::class, 'midtermFormat']);
      Route::get('/exam/format', [SettingController::class, 'examFormat']);
    });

    Route::group(['prefix' => 'staffs', 'namespace' => 'Staffs'], function () {
        Route::get('/', [StaffController::class, 'index']);
        Route::get('/single/{id}', [StaffController::class, 'single']);
        Route::post('/', [StaffController::class, 'store']);
        Route::post('/assign/grade', [StaffController::class, 'assignClass']);
        Route::get('/grade/{id}/delete/{staff}', [StaffController::class, 'deleteGrade']);
        Route::post('/activate', [StaffController::class, 'activate']);
    });

    Route::group(['prefix' => 'student', 'namespace' => 'Student'], function () {
        Route::get('/all', [StudentController::class, 'index']);
        Route::get('/single/{id}', [StudentController::class, 'single']);
        Route::get('/assign/grade', [StudentController::class, 'assignStudent']);
        Route::post('/toggle/status', [StudentController::class, 'toggleStudent']);
        Route::get('/delete/{id}', [StudentController::class, 'delete']);
        Route::post('/multiple/subject/assign', [StudentController::class, 'assignSubjects']);
        Route::get('/{id}/delete/{subject}', [StudentController::class, 'deleteSubject']);
    });

    Route::group(['prefix' => 'registration', 'namespace' => 'Registration'], function () {
        Route::get('/all', [RegistrationController::class, 'index']);
        Route::get('/single/{id}', [RegistrationController::class, 'single']);
        Route::post('/activate', [RegistrationController::class, 'activate']);
    });

    Route::group(['prefix' => 'attendance', 'namespace' => 'Attendance'], function () {
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

    Route::group(['prefix' => 'result', 'namespace' => 'Result'], function () {
        Route::get('/', [ResultController::class, 'index']);
        Route::post('/upload', [ResultController::class, 'store']);
    });
}); 