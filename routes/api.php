<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\v1\UserResource;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TokenAuthController;
use App\Http\Controllers\API\v1\{
    StaffController,
    ResultController,
    SettingController,
    StudentController,
    AttendanceController,
    RegistrationController
};

use App\Http\Controllers\ResultController as WebResultController;
use App\Http\Controllers\OtherBrowserSessionsController;
use App\Scopes\HasActiveScope;

Route::middleware('guest')->group(
    function () {
        $limiter = config('fortify.limiters.login');

        Route::post('/auth/login', [TokenAuthController::class, 'store'])->middleware(
            array_filter([$limiter ? 'throttle:' . $limiter : null])
        );
    }
);

Route::get('get-site-roles', [SettingController::class, 'getSiteRoles']);
Route::get('get-site-permissions', [SettingController::class, 'getSitePermissions']);
Route::get('get-role-permissions/{id}', [SettingController::class, 'getRolePermissions']);

Route::post('/whatsapp-result', [ResultController::class, "whatsappResult"]);
Route::get('/whatsapp-student', function (Request $request) {
    $phone = $request->query('number');
    
    if (!$phone) {
        return response()->json(['error' => 'Phone number is required.'], 400);
    }

    $students = \App\Models\Student::withoutGlobalScope(HasActiveScope::class)->with(['father', 'mother', 'guardian', 'grade', 'user'])
    ->whereHas('father', fn ($q) => $q->where('phone', $phone))
    ->orWhereHas('mother', fn ($q) => $q->where('phone', $phone))
    ->orWhereHas('guardian', fn ($q) => $q->where('phone_number', $phone))
    ->get();

    if ($students->isEmpty()) {
        return response()->json(['status' => false, 'message' => 'Students not found.'], 400);
    }

    return response()->json($students);
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {

    //users
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });

    Route::delete('/auth/token', [TokenAuthController::class, 'destroy']);
    Route::get('/me', [UserController::class, 'me']);
    Route::get('/assigned/grades', [UserController::class, 'assignedGrade']);
    Route::get('/user/sessions', [OtherBrowserSessionsController::class, 'index']);
    Route::post('/user/sessions/purge', [OtherBrowserSessionsController::class, 'destroy']);
    Route::put('/update/user/{id}', [UserController::class, 'update']);
    Route::put('/profile/update/image/{id}', [UserController::class, 'updateImage']);

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
        Route::get('/delete/{id}', [StaffController::class, 'delete']);
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
        Route::get('show/{student_id}/{period_id}/{term_id}', [ResultController::class, 'show'])->name('show');
    });

    Route::group(['prefix' => 'webresults', 'namespace' => 'Webresults'], function () {
        Route::get('/fetch/exam/{student_id}/{period_id}/{term_id}/{grade_id}', [WebResultController::class, 'examFetch'])->name('fetch.exam');
        Route::get('exam/check/{grade_id}/{period_id}/{term_id}', [WebResultController::class, 'checkExam'])->name('check.exam');
    });
});