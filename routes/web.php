<?php

use App\Models\Club;
use App\Models\Grade;
use App\Models\House;
use App\Models\Schedule;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SubGradeController;
use App\Http\Controllers\MessagingController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContestantController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\BiometricDeviceController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/registration', function () {
    // return view('registration',[
    //     'grades' => Grade::all(),
    // ]);
    return abort(500, 'Something went wrong!');
});

Route::post('/pre-student/registration', [RegistrationController::class, 'store']);

Route::get('/setup/user', [VisitorController::class, 'setupUser'])->name('setupUser');
Route::post('/setup/user', [VisitorController::class, 'register'])->name('visitor.register');
Route::post('/setup/logo', [VisitorController::class, 'uploadLogo'])->name('app.logo');
Route::post('/setup/details', [VisitorController::class, 'saveAppDetails'])->name('app.details');

Route::post('/pay', [PaymentController::class, 'redirectToGateway'])->name('pay');
Route::get('/payment/callback', [PaymentController::class, 'handleGatewayCallback']);
Route::get('/payment/receipt/{payment}', [PaymentController::class, 'receipt'])->name('receipt');

Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

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
        Route::get('generate/pin', [UserController::class, 'generatePin'])->name('generatePin');
        Route::get('pins', [UserController::class, 'pins'])->name('pins');
        Route::get('certificate', [UserController::class, 'certificate'])->name('certificate');
    });

    Route::group(['prefix' => 'teacher', 'as' => 'teacher.'], function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index');
        Route::get('/students', [TeacherController::class, 'students'])->name('students');
        Route::post('assignClass', [TeacherController::class, 'assignClass'])->name('assignClass');
        Route::get('/student/edit/{id}', [TeacherController::class, 'edit']);
        Route::post('/student/update', [TeacherController::class, 'update'])->name('student.update');
    });
    
    Route::group(['prefix' => 'order', 'as' => 'order.'], function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'payment', 'as' => 'payment.'], function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
    });

    Route::resource('task',TaskController::class);
    Route::resource('contest',ContestController::class);

    Route::resource('setting',ApplicationController::class);

    Route::resource('period',PeriodController::class);
    Route::resource('grade',GradeController::class);
    Route::resource('subgrade', SubGradeController::class);
    Route::resource('subject',SubjectController::class);
    Route::resource('term',TermController::class);
    Route::resource('house', HouseController::class);
    Route::resource('club', ClubController::class);

    Route::group(['prefix' => 'student', 'as' => 'student.'], function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::post('/', [StudentController::class, 'store'])->name('store');
        Route::get('show/{student}', [StudentController::class, 'show'])->name('show');
        Route::get('edit/{student}', [StudentController::class, 'edit'])->name('edit');
        Route::get('create', [StudentController::class, 'create'])->name('create');
        Route::put('/{student}', [StudentController::class, 'update'])->name('update');
        Route::post('assignSubject', [StudentController::class, 'assignSubject'])->name('assignSubject');
        Route::get('/school/fees', [GeneralController::class, 'fees'])->name('fees');
        Route::post('/update/mother', [GeneralController::class, 'motherUpdate']);
        Route::post('/update/father', [GeneralController::class, 'fatherUpdate']);
        Route::post('/update/guardian', [GeneralController::class, 'guardianUpdate']);
        Route::get('/parent/publish', [GeneralController::class, 'parentPublish']);
        Route::get('/promotion', [PromotionController::class, 'index'])->name('batch.promotion');
        Route::get('/single/promotion', [PromotionController::class, 'single'])->name('single.promotion');
        Route::get('/students-by-class', [StudentController::class, 'getStudentsByClass']);
        Route::get('/performance-by-student', [StudentController::class, 'getPerformanceByStudent']);
        Route::get('/class-ranking-student', [StudentController::class, 'getClassRanking']);
        Route::get('/subjects/{id}', [StudentController::class, 'subjects'])->name('subjects');
    });

    Route::group(['prefix' => 'assignment', 'as' => 'assignment.'], function () {
        Route::get('/', [AssignmentController::class, 'index'])->name('index');
        Route::get('/student/assignment', [AssignmentController::class, 'get'])->name('get');
        Route::post('/', [AssignmentController::class, 'store'])->name('store');
        Route::get('/assignment/publish', [AssignmentController::class, 'publish'])->name('publish');
        Route::get('/show/{assignment}', [AssignmentController::class, 'show'])->name('show');
        Route::get('download/{id}', [AssignmentController::class, 'downloadFile'])->name('download');
    });

    Route::group(['prefix' => 'result', 'as' => 'result.'], function () {
        Route::get('/', [ResultController::class, 'index'])->name('index');
        Route::get('/all/midterm', [ResultController::class, 'midtermIndex'])->name('midtermIndex');
        Route::post('/', [ResultController::class, 'store'])->name('store');
        Route::get('primary/show/{student}', [ResultController::class, 'primaryShow'])->name('primary.show');
        Route::get('midterm/show/{student}', [ResultController::class, 'midtermShow'])->name('midterm.show');
        Route::get('show/{student}', [ResultController::class, 'show'])->name('show');
        Route::get('edit/{result}', [ResultController::class, 'edit'])->name('edit');
        Route::get('create', [ResultController::class, 'create'])->name('create');
        Route::get('/singleUpload', [ResultController::class, 'singleUpload'])->name('singleUpload');
        // Route::post('/singleUpload', [ResultController::class, 'storeSingleUpload'])->name('storeSingleUpload');
        Route::post('/storeSinglePrimaryUpload', [ResultController::class, 'singlePrimaryUpload'])->name('storeSinglePrimaryUpload');

        Route::get('/midterm/upload', [ResultController::class, 'midTermUpload'])->name('midterm.upload');
        Route::post('/store/midterm/score', [ResultController::class, 'storeMidTerm'])->name('upload.midterm.score');

        Route::get('/single/secondary', [ResultController::class, 'secondaryUpload'])->name('secondary.upload');
        Route::post('/store/Single/Secondary/Upload', [ResultController::class, 'storeSecondaryUpload'])->name('storeSingleSecondaryUpload');

        Route::get('/check/secondary', [ResultController::class, 'secondary'])->name('secondary');
        Route::get('/check/primary', [ResultController::class, 'primary'])->name('primary');
        Route::get('/check/midterm', [ResultController::class, 'midterm'])->name('midterm');
        Route::get('/psychomotor/get', [ResultController::class, 'psychomotor'])->name('psychomotor.get');
        Route::post('/psychomotor/upload', [ResultController::class, 'psychomotorUpload'])->name('psychomotor.upload');

        Route::get('/affective/get', [ResultController::class, 'affective'])->name('affective.get');
        Route::post('/affective/upload', [ResultController::class, 'affectiveUpload'])->name('affective.upload');
        Route::get('/publish/cummulative', [ResultController::class, 'publish']);
        Route::get('/primary/publish/cummulative', [ResultController::class, 'primaryPublish'])->name('primary.publish');
        Route::get('/midterm/publish/cummulative', [ResultController::class, 'midtermPublish'])->name('midterm.publish');

        Route::get('/cummulative/get', [ResultController::class, 'cummulative'])->name('cummulative.get');
        Route::get('/verify/pin', [ResultController::class, 'verify']);

        Route::get('/data/midterm', [ResultController::class, 'getMidTermData']);
    });
    
    Route::group(['prefix' => 'fee', 'as' => 'fee.'], function () {
        Route::get('/', [FeeController::class, 'index'])->name('index');
        Route::post('/', [FeeController::class, 'store'])->name('store');
        Route::get('show/{student}', [FeeController::class, 'show'])->name('show');
        Route::get('edit/{student}', [FeeController::class, 'edit'])->name('edit');
        Route::get('create', [FeeController::class, 'create'])->name('create');
        Route::put('/{student}', [FeeController::class, 'update'])->name('update');
        Route::post('assignSubject', [FeeController::class, 'assignSubject'])->name('assignSubject');
    });

    Route::group(['prefix' => 'event', 'as' => 'event.'], function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::post('/', [EventController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [EventController::class, 'edit'])->name('edit');
        Route::post('/update', [EventController::class, 'update'])->name('update');
        Route::delete('/{id}', [EventController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'news', 'as' => 'news.'], function () {
        Route::get('/', [NewsController::class, 'index'])->name('index');
        Route::post('/', [NewsController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'staff', 'as' => 'staff.'], function () {
        Route::get('/', [StaffController::class, 'index'])->name('index');
        Route::post('/', [StaffController::class, 'store'])->name('store');
        Route::get('/bank/list', [StaffController::class, 'bankList']);
        Route::get('/bank/single/{code}', [StaffController::class, 'bankSingle']);
        Route::get('/profile/edit/{id}', [StaffController::class, 'editProfile']);
        Route::post('/update/profile', [StaffController::class, 'updateProfile'])->name('update');
        Route::get('/calender', [StaffController::class, 'calender'])->name('calender');
    });

    Route::group(['prefix' => 'schedule', 'as' => 'schedule.'], function () {
        Route::get('/', [ScheduleController::class, 'index'])->name('index');
        Route::get('/fetch', [ScheduleController::class, 'fetch'])->name('fetch');
        Route::post('/', [ScheduleController::class, 'store'])->name('store');
        Route::get('/edit-schedule/{id}', [ScheduleController::class, 'edit']);
        Route::post('/update-schedule/{id}', [ScheduleController::class, 'update']);
        Route::delete('/', [ScheduleController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'attendance', 'as' => 'attendance.'], function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        Route::post('/', [AttendanceController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'check', 'as' => 'check.'], function () {
        Route::get('/check', [CheckController::class, 'index'])->name('index');
        Route::get('/sheet-report', [CheckController::class, 'sheetReport'])->name('sheet-report');
        Route::post('/Check-store', [CheckController::class, 'CheckStore'])->name('check_store');
    });

    Route::group(['prefix' => 'option', 'as' => 'option.'], function () {
        Route::get('/options/get', [OptionsController::class, 'getOption'])->name('get');
        Route::get('/options/branch/get', [OptionsController::class, 'getBranchOption'])->name('branch.get');
        Route::post('/options/branch/put', [OptionsController::class, 'putBranchOption'])->name('branch.post');
    });

    Route::get('/get/banks', [OptionsController::class, 'banks'])->name('banks');
    
    Route::group(['prefix' => 'messaging', 'as' => 'messaging.'], function () {
        Route::get('/email', [MessagingController::class, 'indexEmail'])->name('email');
        Route::post('/messaging/email/send', [MessagingController::class, 'sendEmail'])->name('sendMail');
        Route::get('/messaging/sms', [MessagingController::class, 'indexSMS'])->name('sms');
        Route::post('/messaging/sms/send', [MessagingController::class, 'sendSMS'])->name('sendSMS');
    });

    Route::group(['prefix' => 'lesson', 'as' => 'lesson.'], function () {
        Route::get('/', [LessonController::class, 'index'])->name('index');
        Route::get('/teacher', [LessonController::class, 'create'])->name('teacher');
        Route::get('show/{lesson}', [LessonController::class, 'show'])->name('show');
        Route::post('/', [LessonController::class, 'store'])->name('store');
        Route::patch('/{id}', [LessonController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [LessonController::class, 'destroy'])->name('destroy');
        Route::get('download/{id}', [LessonController::class, 'downloadFile'])->name('download');
    });

    // Fingerprint Devices
    Route::resource('/finger_device', BiometricDeviceController::class);

    Route::delete('finger_device/destroy', [BiometricDeviceController::class, 'massDestroy'])->name('finger_device.massDestroy');
    Route::get('finger_device/{fingerDevice}/employees/add', [BiometricDeviceController::class, 'addEmployee'])->name('finger_device.add.employee');
    Route::get('finger_device/{fingerDevice}/get/attendance', [BiometricDeviceController::class, 'getAttendance'])->name('finger_device.get.attendance');
    
    // Temp Clear Attendance route
    Route::get('finger_device/clear/attendance', function () {
        $midnight = \Carbon\Carbon::createFromTime(23, 50, 00);
        $diff = now()->diffInMinutes($midnight);
        dispatch(new ClearAttendanceJob())->delay(now()->addMinutes($diff));
        toast("Attendance Clearance Queue will run in 11:50 P.M}!", "success");

        return back();
    })->name('finger_device.clear.attendance');

    Route::group(['prefix' => 'comments', 'as' => 'comments.'], function () {
        Route::post('/', [CommentController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'design', 'as' => 'design.'], function () {
        Route::get('/', [FrontendController::class, 'index'])->name('index');
        Route::post('/', [FrontendController::class, 'banner'])->name('banner');
        Route::post('/about', [FrontendController::class, 'about'])->name('about');
        Route::post('/choose', [FrontendController::class, 'choose'])->name('choose');
        Route::get('/show/banner', [FrontendController::class, 'bannerShow']);
        Route::get('/show/about', [FrontendController::class, 'aboutShow']);
    });

    Route::group(['prefix' => 'timetable', 'as' => 'timetable.'], function () {
        Route::get('/', [TimetableController::class, 'index'])->name('index');
        Route::post('/', [TimetableController::class, 'store'])->name('store');
    });

    Route::get('/index/registration', [RegistrationController::class, 'index']);
    Route::get('/show/registration/{registration}', [RegistrationController::class, 'show']);
    Route::delete('/delete/registration/{id}', [RegistrationController::class, 'destroy']);
    Route::get('/compare/registration', [RegistrationController::class, 'compare']);
    Route::get('/sync/parent', [RegistrationController::class, 'syncParent']);
    Route::get('/accept/student/{id}', [RegistrationController::class, 'accept']);
    Route::get('/resync/parent/{id}', [RegistrationController::class, 'resyncParent']);
    Route::post('/accept/student/all', [RegistrationController::class, 'acceptAll']);
    Route::post('/sync/parent/all', [RegistrationController::class, 'syncAll']);
    Route::get('/pending/registration', [RegistrationController::class, 'pending'])->name('pending.registration');


    Route::group(['prefix' => 'upload', 'as' => 'upload.'], function () {
        Route::get('/', [FrontendController::class, 'uploadSignature'])->name('uploadSignature');
        Route::post('/', [FrontendController::class, 'uploadSignaturePost'])->name('uploadSignature');
    });

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

Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    $enableViews = config('fortify.views', true);

    // Authentication...
    if ($enableViews) {
        Route::get('/login', [LoginController::class, 'showLoginForm'])
            ->middleware(['guest:'.config('fortify.guard')])
            ->name('login');
        Route::get('/student/login', [LoginController::class, 'showStudentLoginForm'])
        ->middleware(['guest:'.config('fortify.guard')])
        ->name('student/login');
    }

    $limiter = config('fortify.limiters.login');
    $twoFactorLimiter = config('fortify.limiters.two-factor');
    $verificationLimiter = config('fortify.limiters.verification', '6,1');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:'.config('fortify.guard'),
            $limiter ? 'throttle:'.$limiter : null,
        ]));

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Password Reset...
    if (Features::enabled(Features::resetPasswords())) {
        if ($enableViews) {
            Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware(['guest:'.config('fortify.guard')])
                ->name('password.request');

            Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware(['guest:'.config('fortify.guard')])
                ->name('password.reset');
        }

        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
            ->middleware(['guest:'.config('fortify.guard')])
            ->name('password.email');

        Route::post('/reset-password', [NewPasswordController::class, 'store'])
            ->middleware(['guest:'.config('fortify.guard')])
            ->name('password.update');
    }

    // Registration...
    if (Features::enabled(Features::registration())) {
        if ($enableViews) {
            Route::get('/register', [RegisteredUserController::class, 'create'])
                ->middleware(['guest:'.config('fortify.guard')])
                ->name('register');
        }

        Route::post('/register', [RegisteredUserController::class, 'store'])
            ->middleware(['guest:'.config('fortify.guard')]);
    }

    // Email Verification...
    if (Features::enabled(Features::emailVerification())) {
        if ($enableViews) {
            Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
                ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
                ->name('verification.notice');
        }

        Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
            ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard'), 'signed', 'throttle:'.$verificationLimiter])
            ->name('verification.verify');

        Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard'), 'throttle:'.$verificationLimiter])
            ->name('verification.send');
    }

    // Profile Information...
    if (Features::enabled(Features::updateProfileInformation())) {
        Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
            ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
            ->name('user-profile-information.update');
    }

    // Passwords...
    if (Features::enabled(Features::updatePasswords())) {
        Route::put('/user/password', [PasswordController::class, 'update'])
            ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
            ->name('user-password.update');
    }

    // Password Confirmation...
    if ($enableViews) {
        Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')]);
    }

    Route::get('/user/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])
        ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
        ->name('password.confirmation');

    Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])
        ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
        ->name('password.confirm');

    // Two Factor Authentication...
    if (Features::enabled(Features::twoFactorAuthentication())) {
        if ($enableViews) {
            Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])
                ->middleware(['guest:'.config('fortify.guard')])
                ->name('two-factor.login');
        }

        Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
            ->middleware(array_filter([
                'guest:'.config('fortify.guard'),
                $twoFactorLimiter ? 'throttle:'.$twoFactorLimiter : null,
            ]));

        $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
            ? [config('fortify.auth_middleware', 'auth').':'.config('fortify.guard'), 'password.confirm']
            : [config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')];

        Route::post('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.enable');

        Route::post('/user/confirmed-two-factor-authentication', [ConfirmedTwoFactorAuthenticationController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.confirm');

        Route::delete('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.disable');

        Route::get('/user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.qr-code');

        Route::get('/user/two-factor-secret-key', [TwoFactorSecretKeyController::class, 'show'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.secret-key');

        Route::get('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.recovery-codes');

        Route::post('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
            ->middleware($twoFactorMiddleware);
    }
});
