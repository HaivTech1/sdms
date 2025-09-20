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
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ResultController as WebResultController;
use App\Http\Controllers\StudentController as WebStudentController;
use App\Http\Controllers\AttendanceController as WebAttendanceController;
use App\Http\Controllers\StaffController as WebStaffController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OtherBrowserSessionsController;
use App\Scopes\HasActiveScope;

Route::get('/search-students', [HomeController::class, 'searchStudents']);

Route::middleware('guest')->group(
    function () {
        $limiter = config('fortify.limiters.login');

        Route::post('/auth/login', [TokenAuthController::class, 'store'])->middleware(
            array_filter([$limiter ? 'throttle:' . $limiter : null])
        );

        Route::post('/auth/student/login', [StudentController::class, 'login'])->middleware(
            array_filter([$limiter ? 'throttle:' . $limiter : null])
        );
    }
);

Route::get('get-site-roles', [SettingController::class, 'getSiteRoles']);
Route::get('get-site-permissions', [SettingController::class, 'getSitePermissions']);
Route::get('get-role-permissions/{id}', [SettingController::class, 'getRolePermissions']);

Route::post('/whatsapp-result', [ResultController::class, "whatsappResult"]);
Route::post('/whatsapp-fee', [StudentController::class, "getStudentFee"]);
Route::get('/whatsapp-classes', [StudentController::class, "getClasses"]);

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

Route::get('/whatsapp-student-fee', function (Request $request) {
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
    Route::post('/update/device-token', [UserController::class, 'updateDeviceToken']);

    Route::group(['prefix' => 'settings', 'namespace' => 'Settings'], function () {
        Route::get('/', [SettingController::class, 'index']);
        Route::get('/levels/all', [SettingController::class, 'grade']);
        Route::get('/sessions/all', [SettingController::class, 'session']);
        Route::get('/terms/all', [SettingController::class, 'term']);
        Route::get('/subjects/all', [SettingController::class, 'subject']);
        Route::get('/houses/all', [SettingController::class, 'houses']);
        Route::get('/clubs/all', [SettingController::class, 'clubs']);
        Route::get('/schedules/all', [SettingController::class, 'schedules']);
        Route::get('/midterm/format', [SettingController::class, 'midtermFormat']);
        Route::get('/exam/format', [SettingController::class, 'examFormat']);
        Route::get("/dashboard/summary", [SettingController::class, 'dashboardSummary']);

        Route::get("/term-settings", [ApplicationController::class, 'getTermSetting']);
        Route::get("/single/term-settings/{id}", [ApplicationController::class, 'getSingleTermSetting']);
        Route::post("/term-settings", [ApplicationController::class, 'termSetting']);
        Route::delete("/term-settings/{id}", [ApplicationController::class, 'deleteTermSetting']);
        Route::put("/term-settings/{id}", [ApplicationController::class, 'updateTermSetting']);
    });

    Route::group(['prefix' => 'staffs', 'namespace' => 'Staffs'], function () {
        Route::get('/', [StaffController::class, 'index']);
        Route::get('/single/{id}', [StaffController::class, 'single']);
        Route::post('/', [StaffController::class, 'store']);
        Route::post('/assign/grade', [StaffController::class, 'assignClass']);
        Route::post('/assign/subject', [StaffController::class, 'assignSubject']);
        Route::get('/grade/{id}/delete/{staff}', [StaffController::class, 'deleteGrade']);
        Route::post('/activate', [StaffController::class, 'activate']);
        Route::delete('/delete/{id}', [StaffController::class, 'delete']);
        Route::put('/{id}', [StaffController::class, 'update'])->name('update');
        Route::post('/update/password/{id}', [StaffController::class, 'updatePassword']);
        Route::get('/generate-qrcode/{id}', [WebStaffController::class, 'generateQr']);
    });

    Route::group(['prefix' => 'student', 'namespace' => 'Student'], function () {
        Route::get("/me", [StudentController::class, "me"]);
        Route::get('/all', [StudentController::class, 'index']);
        Route::post('/', [WebStudentController::class, 'store']);
        Route::get('/single/{id}', [StudentController::class, 'single']);
        Route::get('/assign/grade', [StudentController::class, 'assignStudent']);
        Route::post('/toggle/status', [StudentController::class, 'toggleStudent']);
        Route::get('/delete/{id}', [StudentController::class, 'delete']);
        Route::post('/subject/assign', [WebStudentController::class, 'assignSubject']);
        Route::get('/{id}/delete/{subject}', [StudentController::class, 'deleteSubject']);


        Route::put('/{student}', [WebStudentController::class, 'update'])->name('update');
        Route::post('/update/mother', [GeneralController::class, 'motherUpdate']);
        Route::post('/update/father', [GeneralController::class, 'fatherUpdate']);
        Route::post('/update/guardian', [GeneralController::class, 'guardianUpdate']);

        Route::get('/send-credentials/{student}', [WebStudentController::class, 'sendCredentials']);
        Route::put('/update-password/{student}', [WebStudentController::class, 'updateUserPassword']);
        Route::get('/generate-qrcode/{student}', [WebStudentController::class, 'generateQr']);

    });

    Route::group(['prefix' => 'registration', 'namespace' => 'Registration'], function () {
        Route::get('/all', [RegistrationController::class, 'index']);
        Route::get('/single/{id}', [RegistrationController::class, 'single']);
        Route::get('/accept/{id}', [RegistrationController::class, 'accept']);
        Route::get('/reject/{id}', [RegistrationController::class, 'reject']);
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

        Route::get("/daily", [WebAttendanceController::class, "myAttendance"]);
        Route::post("/daily", [WebAttendanceController::class, 'storeDailyAttendance']);
        Route::delete("/daily/{id}", [WebAttendanceController::class, 'deleteDailyAttendance']);
        Route::post("/daily/export", [WebAttendanceController::class, 'exportAttendance']);
    });

    Route::group(['prefix' => 'result', 'namespace' => 'Result'], function () {
        Route::get('/', [ResultController::class, 'index']);
        Route::post('/midterm/upload', [WebResultController::class, 'storeMidTerm']);
        Route::post('/exam/upload', [WebResultController::class, 'singlePrimaryUpload']);

        Route::post('/midterm/batch/upload', [WebResultController::class, 'storeBatchMidterm']);
        Route::post('/exam/batch/upload', [WebResultController::class, 'batchExamUpload']);

        Route::post('/publish/midterm', [WebResultController::class, 'midtermPublish']);
        Route::post('/publish/exam', [WebResultController::class, 'primaryPublish']);

        Route::get('show/{student_id}/{period_id}/{term_id}', [ResultController::class, 'show'])->name('show');

        Route::get('/fetch/midterm/{student_id}/{period_id}/{term_id}/{grade_id}', [WebResultController::class,
        'midtermFetch']);
        Route::get('/fetch/exam/{student_id}/{period_id}/{term_id}/{grade_id}', [WebResultController::class,
        'examFetch']);

        Route::get('/sync/position/student/{student_id}/{period_id}/{term_id}', [WebResultController::class,
        'syncStudentPosition']);
        Route::get('/single/position/student/{student_id}/{period_id}/{term_id}', [WebResultController::class,
        'syncStudentSinglePosition']);

        Route::get('/psychomotor', [ResultController::class, 'psychomotor']);
        Route::post('/psychomotor/upload', [WebResultController::class, 'psychomotorUpload']);

        Route::get('/affective', [ResultController::class, 'affective']);
        Route::post('/affective/upload', [WebResultController::class, 'affectiveUpload']);

        Route::get('/cognitive', [ResultController::class, 'cognitive']);
        Route::post('/cognitive/upload', [WebResultController::class, 'cognitiveUpload']);
    });

    Route::group(['prefix' => 'webresults', 'namespace' => 'Webresults'], function () {
        Route::get('/fetch/exam/{student_id}/{period_id}/{term_id}/{grade_id}', [WebResultController::class, 'examFetch'])->name('fetch.exam');
        Route::get('exam/check/{grade_id}/{period_id}/{term_id}', [WebResultController::class, 'checkExam'])->name('check.exam');
    });

    Route::group(['prefix' => 'news', 'namespace' => 'News'], function () {
        Route::get('/all', [NewsController::class, 'index']);
        Route::post('/create', [NewsController::class, 'store']);
        Route::put('/update/{id}', [NewsController::class, 'update']);
        Route::delete('/delete/{id}', [NewsController::class, 'delete']);
    });

    Route::group(['prefix' => 'events', 'namespace' => 'events'], function () {
        Route::get('/', [EventController::class, 'list']);
        Route::post('/create', [EventController::class, 'store']);
        Route::put('/update/{id}', [EventController::class, 'update']);
        Route::delete('/delete/{id}', [EventController::class, 'delete']);
        Route::get('/notify/{id}', [EventController::class, 'notify']);
    });

    Route::group(['prefix' => 'fees', 'namespace' => 'fees'], function () {
        Route::get('/', [FeeController::class, 'list']);
        Route::get('/single/{id}', [FeeController::class, 'single']);
        Route::post('/create', [FeeController::class, 'store']);
        Route::put('/update', [FeeController::class, 'update']); 
        Route::delete('/delete/{id}', [FeeController::class, 'delete']);
        Route::get('/notify/{id}', [FeeController::class, 'notify']);
        Route::get('/toggle/{id}', [FeeController::class, 'toggle']);
        Route::get('/payments', [FeeController::class, 'payments']);
        Route::get('/payments/{id}', [FeeController::class, 'paymentDetails']);
        Route::post('/payments/create', [FeeController::class, 'createPayment']);
        Route::delete('/payments/{id}', [FeeController::class, 'deletePayment']);
        Route::get('/payments/receipt/download/{id}', [FeeController::class,
        'downloadReceipt'])->name('receipt.download');
        Route::get('/outstandings', [FeeController::class, 'outstandings']);
        Route::post('/outstandings/create', [FeeController::class, 'addOutstanding']);
        Route::post('/outstandings/delete', [FeeController::class, 'deleteOutstanding']);
    });
});