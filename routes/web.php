<?php

use App\Models\Grade;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\EventController;

// Event notification batch admin routes
Route::get('/admin/events/batch/{batchId}', [EventController::class, 'batchView'])->name('admin.events.batch.view');
Route::get('/admin/events/batch-info/{batchId}', [EventController::class, 'getBatchInfo'])->name('admin.events.batch.info');
Route::post('/admin/events/{id}/notify-parents', [EventController::class, 'sendNotificationToParents'])->name('admin.events.notify.parents');
use App\Http\Controllers\GradeController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SubGradeController;
use App\Http\Controllers\HairstyleController;
use App\Http\Controllers\MessagingController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContestantController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\User\MarketController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\OrderPaymentController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\User\SchoolBusController;
use App\Http\Controllers\BiometricDeviceController;
use App\Http\Controllers\Admin\PermissionController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\TwoFactorSecretKeyController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

Route::get('/search-students', [HomeController::class, 'searchStudents']);

Route::get('/check-student', function () {
   $result = \App\Models\MidTerm::where("student_id", "38919144-3dcc-4a8c-8a5e-ab9411bba625")->where('period_id', '5')->where('term_id', '2')->get();
   dd($result);
});

Route::get('/test-email', function () {
   try{
     \Illuminate\Support\Facades\Mail::to("shittuopeyemi24@gmail.com")->send(new \App\Mail\SendMidtermMail("Test Email", "Test Email"));
   }catch(\Throwable $th){
    dd($th);
   }
});

Route::get('/calculate-status-totals', function () {
    $inputFile = public_path('user_33535_transactions.json'); // Input file
    $outputFile = public_path('user_33535_transactions.txt'); // Output file

    // Load the JSON file as an array
    $jsonData = json_decode(File::get($inputFile), true);

    if (!is_array($jsonData)) {
        return "Invalid JSON structure in the file!";
    }

    // Group transactions by `created_at` and calculate totals for each `status`
    $totalsByDate = [];

    foreach ($jsonData as $record) {
        if (isset($record['created_at'], $record['status'], $record['amount'])) {
            $createdAt = Carbon::parse($record['created_at'])->toDateString();
            $status = $record['status'];
            $amount = floatval($record['amount']); // Convert to float for summing

            if (!isset($totalsByDate[$createdAt])) {
                $totalsByDate[$createdAt] = [
                    'success' => 0,
                    'unsuccessful' => 0,
                    'refund' => 0,
                    'total_amount' => 0
                ];
            }

            if ($status === "success" || $status === "unsuccessful" || $status === "refund") {
                $totalsByDate[$createdAt][$status] += 1;  // Count transactions per status
                $totalsByDate[$createdAt]['total_amount'] += $amount;  // Sum amounts
            }
        }
    }

    // Format the results into a readable string for each date
    $formattedResults = [];
    foreach ($totalsByDate as $date => $data) {
        $formattedResults[] = "Date: {$date}\n"
            . "  Successes: {$data['success']}\n"
            . "  Unsuccessful: {$data['unsuccessful']}\n"
            . "  Refunds: {$data['refund']}\n"
            . "  Total Amount: {$data['total_amount']}\n";
    }

    // Write results to the output txt file
    File::put($outputFile, implode("\n", $formattedResults));

    return response()->json(['message' => 'Totals saved to text file successfully!']);
});

Route::get('/filter-transactions', function () {
    $inputFile = public_path('filtered_transactions.json'); // Output directory

    // Define the date range
    $startDate = Carbon::create(2025, 1, 13); // Start date
    $endDate = Carbon::today(); // Today's date

    // Load the JSON file as an array
    $jsonData = json_decode(File::get($inputFile), true);

    if (!is_array($jsonData)) {
        return "Invalid JSON structure in the file!";
    }

    // Filter records based on the date range
    $filteredData = array_filter($jsonData, function ($record) use ($startDate, $endDate) {
        if (isset($record['created_at'])) {
            $createdAt = Carbon::parse($record['created_at']);
            return $createdAt->between($startDate, $endDate);
        }
        return false;
    });

    // User IDs to separate
    $userIds = ['36085', '33535', '27510'];

    // Separate and save records for each user ID
    foreach ($userIds as $userId) {
        $userTransactions = array_filter($filteredData, function ($record) use ($userId) {
            return isset($record['user_id']) && $record['user_id'] == $userId;
        });

        $userOutputFile = "user_{$userId}_transactions.json";

        File::put($userOutputFile, json_encode(array_values($userTransactions), JSON_PRETTY_PRINT));
    }

    return "Filtered transactions saved";
});

Route::get('/filter-service-type', function () {
    $inputFile = public_path('user_27510_transactions.json'); // Input file
    $outputFile = $inputFile; // Overwrite the same file

    // Load the JSON file as an array
    $jsonData = json_decode(File::get($inputFile), true);

    if (!is_array($jsonData)) {
        return "Invalid JSON structure in the file!";
    }

    // Filter records where service_type is "Data Topup"
    $filteredData = array_filter($jsonData, function ($record) {
        return isset($record['service_type']) && $record['service_type'] === "Data Topup";
    });

    // Save the filtered records back to the file
    File::put($outputFile, json_encode(array_values($filteredData), JSON_PRETTY_PRINT));

    return "Filtered transactions with 'service_type: Data Topup' saved back to the file.";
});

// Theme regeneration endpoint (admin only)
Route::post('/admin/theme/regenerate', [ApplicationController::class, 'regenerateTheme'])
    ->middleware(['auth','admin'])
    ->name('admin.theme.regenerate');

Route::get("/action", function(){
    $students = \App\Models\User::where('type', 4)->get();
    foreach($students as $student){
        $student->update([
            'password' => Hash::make(123456),
        ]);
    }

    return "done";
});

Route::get("/action-merge-midterm", function(){

    $studentsJson = File::get(public_path('students.json'));
    $subjectsJson = File::get(public_path('student_subject.json'));

    $students = json_decode($studentsJson, true);
    $subjects = json_decode($subjectsJson, true);

    foreach ($students as &$student) {
        $student['subjects'] = collect($subjects)
            ->where('student_uuid', $student['uuid'])
            ->pluck('subject_id')
            ->toArray();
    }

    $mergedJson = json_encode($students, JSON_PRETTY_PRINT);
    // File::put(storage_path('app/merged_students.json'), $mergedJson);
    return $students;
});

Route::get("/action-merge-result", function () {
    $fathersJson = File::get(public_path('mid_term4.json'));
    $fathers = json_decode($fathersJson, true);

    $remainingRecords = [];

    foreach ($fathers as $father) {
        $existingFather = \App\Models\Father::where('student_uuid', $father['student_uuid'])->first();

        if (!$existingFather) {
            try {
                \App\Models\Father::create(
                    collect($father)->only((new \App\Models\Father())->getFillable())->toArray()
                );
            } catch (\Exception $e) {
                \Log::error("Failed to insert record: " . $father['student_uuid'] . ". Error: " . $e->getMessage());
            }
        }
    }

    foreach ($fathers as $result) {
        if (!\App\Models\Mother::where('student_uuid', $father['student_uuid'])->exists()) {
            $remainingRecords[] = $result;  
        }
    }

    file_put_contents(public_path('mid_term4.json'), json_encode($remainingRecords));

    return "Imported and records removed from JSON successfully!";
});

Route::get("/action-merge", function () {
    $studentsJson = File::get(public_path('students.json'));
    $subjectsJson = File::get(public_path('student_subject.json'));

    $students = json_decode($studentsJson, true);
    $subjects = json_decode($subjectsJson, true);

    foreach ($students as $studentData) {
        // Check if the student already exists
        $existingStudent = \App\Models\Student::where('uuid', $studentData['uuid'])->first();

        if (!$existingStudent) {
            try {
                // Check if the user exists
                $existingUser = \App\Models\User::find($studentData['user_id']);

                if (!$existingUser) {
                    // Create the user account if it doesn't exist
                    $existingUser = \App\Models\User::create([
                        'title' => 'student',
                        'name' => $studentData['last_name'] . ' ' . $studentData['first_name'] . ' ' . ($studentData['other_name'] ?? ''),
                        'email' => strtolower($studentData['last_name'] . $studentData['first_name']) . '@gmail.com',
                        'phone_number' => '',
                        'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                        'type' => 4, // Assuming '4' corresponds to the role of a student
                    ]);

                    // Optionally generate a registration code
                    $code = \App\Services\SaveCode::Generator(application('alias') . '/', 4, 'reg_no', $existingUser);
                    $existingUser->reg_no = $code;
                    $existingUser->save();

                    // Update the studentData with the new user_id
                    $studentData['user_id'] = $existingUser->id;
                }

                // Insert the new student record
                $newStudent = \App\Models\Student::create(
                    collect($studentData)->only((new \App\Models\Student())->getFillable())->toArray()
                );

                // Sync subjects for the new student
                $studentSubjects = collect($subjects)
                    ->where('student_uuid', $newStudent->uuid)
                    ->pluck('subject_id')
                    ->toArray();

                $newStudent->subjects()->sync($studentSubjects);
            } catch (\Exception $e) {
                // Log any errors and continue
                \Log::error("Failed to insert student: {$studentData['uuid']}. Error: " . $e->getMessage());
            }
        }
    }

    return response()->json(['message' => 'New students and their subjects synced successfully.']);
});

Route::get("/action-merge-get", function () {
    $studentsJson = File::get(public_path('students.json'));
    $students = json_decode($studentsJson, true);

    $missingStudents = [];

    foreach ($students as $studentData) {
        $existingStudent = \App\Models\Student::where('uuid', $studentData['uuid'])->first();

        if (!$existingStudent) {
            $missingStudents[] = $studentData['first_name'] . ' ' . $studentData['last_name'] . ' ' . $studentData['other_name'];
        }
    }

    return response()->json([
        'missing_students_count' => count($missingStudents),
        'missing_students_names' => implode(', ', $missingStudents),
        'message' => 'These students do not exist in the database.'
    ]);
});

Route::get("/action-merge-users", function () {
    $studentsJson = File::get(public_path('students.json'));
    $students = json_decode($studentsJson, true);

    $missingStudents = [];

    foreach ($students as $studentData) {
        $existingStudent = \App\Models\User::where('id', $studentData['user_id'])->first();

        if (!$existingStudent) {
            $missingStudents[] = $studentData['first_name'] . ' ' . $studentData['last_name'] . ' ' . $studentData['other_name'];
        }
    }

    return response()->json([
        'missing_users_count' => count($missingStudents),
        'missing_users_names' => implode(', ', $missingStudents),
        'message' => 'These users do not exist in the database.'
    ]);
});

Route::post('/pre-student/registration', [RegistrationController::class, 'store']);
Route::post('/update/password', [UserController::class, 'updatePassword'])->name('update.password');
Route::post('/request/password', [UserController::class, 'requestPassword'])->name('request.password');


Route::get('/setup/user', [VisitorController::class, 'setupUser'])->name('setupUser');
Route::post('/setup/user', [VisitorController::class, 'register'])->name('visitor.register');
Route::post('/setup/logo', [VisitorController::class, 'uploadLogo'])->name('app.logo');
Route::post('/setup/details', [VisitorController::class, 'saveAppDetails'])->name('app.details');

Route::post('/pay', [PaymentController::class, 'redirectToGateway'])->name('pay');
Route::get('/payment/callback', [PaymentController::class, 'handleGatewayCallback'])->name('payment.recurring');

Route::post('/payment/paystack', [PaymentController::class, 'makePayment'])->name('payment.paystack.initiate');
Route::get('/payment/callback/paystack', [PaymentController::class, 'callback'])->name('payment.paystack.callback');
Route::get('/payment/receipt/{payment}', [PaymentController::class, 'receipt'])->name('receipt');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/assign-student-roles', function(){
        $users = \App\Models\User::where('type', \App\Models\User::STUDENT)->get();

        foreach ($users as $user) {
            $user->roles()->detach();
            $user->roles()->attach(5);
        }

        return "Done";

    });

    Route::get('/generate-student', function(){
        $users = \App\Models\User::where('type', \App\Models\User::STUDENT)->get();

        foreach ($users as $user) {
            $studentData = \App\Models\Student::where('user_id', $user->id)->first();

            if(!$studentData){

                $parts = explode(" ", $user->name);

                $firstName = $parts[1] ?? '';
                $middleName = isset($parts[2]) ? $parts[2] : '';
                $lastName = $parts[0]; 

                $student = new \App\Models\Student([ 
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'other_name' => $middleName,
                    'gender' => "", 
                    'dob' => now(),
                    'nationality' => "Nigerian",
                    'state_of_origin' => "", 
                    'local_government' => "", 
                    'address' => "", 
                    'prev_school' => "", 
                    'prev_class' => "", 
                    'medical_history' => "",
                    'allergics' => "",
                    'religion' => "",
                    'denomination' => "",
                    'blood_group' => "",
                    'genotype' => "",
                    'speech_development' => "",
                    'sight' => "",
                    'grade_id' => 1,
                    'house_id' => 1,
                    'club_id' => 1,
                    'user_id' => $user->id
                ]);

                $student->authoredBy(auth()->user());
                $student->save();
            }
        }

        return "Done";

    });

    Route::middleware('maintenance')->group(function () {

        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
        Route::post('/subject/download/pdf', [SubjectController::class, 'subjectDownloadPdf'])->name('subject.download-pdf');
        Route::post('/subject/download/excel', [SubjectController::class, 'subjectDownloadExcel'])->name('subject.download-excel');
        Route::get('/get/grade/subjects/{grade_id}', [SubjectController::class, 'getGradeSubjects'])->name('grade.subjects');

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
            Route::get('/roles/{id}', [UserController::class, 'roles'])->name('roles');
            Route::post('assign/role', [UserController::class, 'assignRole'])->name('assignRole');
            Route::delete('/{user}/role/{role}', [UserController::class, 'deleteAssignedRole'])->name('assignedRole.delete');
        });

        Route::resource('permission', PermissionController::class);

        Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/destroy', [RoleController::class, 'destroy'])->name('destroy');
            Route::get('/permissions/{id}', [RoleController::class, 'permissions'])->name('permissions');
            Route::post('assignPermission', [RoleController::class, 'assignPermission'])->name('assignPermission');
            Route::delete('/{role}/permission/{permission}', [RoleController::class, 'deleteAssignedPermission'])->name('assignedPermission.delete');
        });

        Route::group(['prefix' => 'teacher', 'as' => 'teacher.'], function () {
            Route::get('/', [TeacherController::class, 'index'])->name('index');
            Route::get('/students', [TeacherController::class, 'students'])->name('students')->middleware('classTeacher');
            Route::post('assignClass', [TeacherController::class, 'assignClass'])->name('assignClass');
            Route::post('assignSubject', [TeacherController::class, 'assignSubject'])->name('assignSubject');
            Route::get('/student/edit/{id}', [TeacherController::class, 'edit']);
            Route::post('/student/update', [TeacherController::class, 'update'])->name('student.update');
            Route::get('/subject/{id}', [TeacherController::class, 'showSubject']);
            Route::get('/subject/{subjectId}/teacher/{teacherId}', [TeacherController::class, 'removeSubject']);
            Route::get('/grade/{gradeId}/teacher/{teacherId}', [TeacherController::class, 'removeGrade']);

            Route::get('/curriculum', [TeacherController::class, 'curriculum'])->name('curriculum');
            Route::post('/curriculum', [TeacherController::class, 'storeCurriculum'])->name('curriculum.store');
            Route::get('/curriculum/{curriculum}/edit', [TeacherController::class, 'editCurriculum'])->name('curriculum.edit');
            Route::put('/curriculum/{curriculum}', [TeacherController::class, 'updateCurriculum'])->name('curriculum.update');
            Route::delete('/curriculum/{curriculum}', [TeacherController::class, 'destroyCurriculum'])->name('curriculum.destroy'); 

            Route::get("curriculum/{curriculum}/topics", [TeacherController::class, 'curriculumTopics'])->name('curriculum.topics');
            Route::post("curriculum/{curriculum}/topics", [TeacherController::class, 'storeCurriculumTopic'])->name('curriculum.topics.store');
            Route::get("curriculum/{curriculum}/topics/{topic}/edit", [TeacherController::class, 'editCurriculumTopic'])->name('curriculum.topics.edit');
            Route::put("curriculum/{curriculum}/topics/{topic}", [TeacherController::class, 'updateCurriculumTopic'])->name('curriculum.topics.update');
            Route::delete("curriculum/{curriculum}/topics/{topic}", [TeacherController::class, 'destroyCurriculumTopic'])->name('curriculum.topics.destroy');
            Route::post("curriculum/{curriculum}/topics/generate", [TeacherController::class, 'generateTopicQuestions'])->name('curriculum.topics.generate');
            Route::post("curriculum/{curriculum}/topics/save-questions", [TeacherController::class, 'storeGeneratedQuestions'])->name('curriculum.topics.save_questions');
            // Save a single question from preview
            Route::post("curriculum/{curriculum}/topics/save-question", [TeacherController::class, 'storeSingleQuestion'])->name('curriculum.topics.save_question');
            // List saved questions for a topic
            Route::get("curriculum/{curriculum}/topics/{topic}/questions", [TeacherController::class, 'questions'])->name('curriculum.topics.questions');
                Route::get("curriculum/{curriculum}/topics/{topic}/attempts", [TeacherController::class, 'topicAttempts'])->name('curriculum.topics.attempts');
            // Download curriculum questions as PDF
            Route::get("curriculum/{curriculum}/download-questions", [TeacherController::class, 'downloadCurriculumQuestionsPdf'])->name('curriculum.download_questions');
            // Update / delete saved question
            Route::put("curriculum/{curriculum}/questions/{question}", [TeacherController::class, 'updateQuestion'])->name('curriculum.topics.question.update');
            Route::delete("curriculum/{curriculum}/questions/{question}", [TeacherController::class, 'destroyQuestion'])->name('curriculum.topics.question.destroy');
            
        });

        Route::group(['prefix' => 'driver', 'as' => 'driver.'], function () {
            Route::get('/', [DriverController::class, 'index'])->name('index');
            Route::post('/', [DriverController::class, 'store'])->name('store');
            Route::post('/assign/vehicle', [DriverController::class, 'assignVehicle'])->name('assignVehicle');
        });

        Route::group(['prefix' => 'vehicle', 'as' => 'vehicle.'], function () {
            Route::get('/', [VehicleController::class, 'index'])->name('index');
            Route::post('/', [VehicleController::class, 'store'])->name('store');
            Route::get('/list', [VehicleController::class, 'list'])->name('list');
        });

        Route::group(['prefix' => 'trip', 'as' => 'trip.'], function () {
            Route::get('/', [TripController::class, 'index'])->name('index');
            Route::post('/', [TripController::class, 'store'])->name('store');
            Route::post('/download-pdf', [TripController::class, 'downloadPdf'])->name('download-pdf');
            Route::post('/generate/paid', [TripController::class, 'generatePaid'])->name('generate.paid');
            Route::post('/generate/unpaid', [TripController::class, 'generateUnPaid'])->name('generate.unpaid');
        });

        Route::group(['prefix' => 'payment', 'as' => 'payment.'], function () {
            Route::get('/', [PaymentController::class, 'index'])->name('index');
            Route::get('/get-students', [PaymentController::class, 'getStudents']);
            Route::post('/verify-payment', [PaymentController::class, 'verifyPayment']);
        });

        Route::resource('setting', ApplicationController::class);

        Route::resource('period', PeriodController::class);
        Route::resource('grade', GradeController::class);
        Route::resource('subgrade', SubGradeController::class);
        Route::resource('subject', SubjectController::class);
        Route::resource('term', TermController::class);
        Route::resource('house', HouseController::class);
        Route::resource('club', ClubController::class);

        Route::get('/grade/students/{grade}', [GradeController::class, 'gradeStudents'])->name('grade.students');
        Route::post('/assign/grade/subjects/{grade}', [GradeController::class, 'assignGradeSubjects'])->name('grade.subjects.assign');
        Route::get('/grade/subjects/{grade}', [GradeController::class, 'gradeSubjects'])->name('grade.subjects');
        Route::post('/grade/update-status', [GradeController::class, 'updateStatus'])->name('grade.update.status');
        Route::post('/grade/delete-all', [GradeController::class, 'deleteAll'])->name('grade.delete.all');

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
            Route::delete('/{student}/subject/{subject}', [StudentController::class, 'deleteAssignedSubject'])->name('assignedSubject.delete');
            Route::post('/upload/passport', [StudentController::class, 'upload']);
            Route::post('/download/pdf', [StudentController::class, 'studentDownloadPdf'])->name('download-pdf');

            Route::get('/cognitive/students/{period}/{term}', [StudentController::class, 'cognitiveStudents'])->name('cognitives');
            Route::get('/psychomotor/students/{period}/{term}', [StudentController::class, 'psychomotorStudents'])->name('psychomotors');
            Route::get('/affective/students/{period}/{term}', [StudentController::class, 'affectiveStudents'])->name('affectives');

            Route::get('/parent-details', [GeneralController::class, 'parentDetails'])->name('parentDetails');
            Route::post('/update-mother-details', [GeneralController::class, 'updateMotherData'])->name('updateMotherData');
            Route::post('/update-father-details', [GeneralController::class, 'updateFatherData'])->name('updateFatherData');

            Route::get('/generate-qrcode/{id}', [StudentController::class, 'generateQr']);
        });

        Route::group(['prefix' => 'assignment', 'as' => 'assignment.'], function () {
            Route::get('/', [AssignmentController::class, 'index'])->name('index');
            Route::get('/student/assignment', [AssignmentController::class, 'get'])->name('get');
            Route::post('/', [AssignmentController::class, 'store'])->name('store');
            Route::get('/assignment/publish', [AssignmentController::class, 'publish'])->name('publish');
            Route::get('/show/{assignment}', [AssignmentController::class, 'show'])->name('show');
            Route::get('download/{id}', [AssignmentController::class, 'downloadFile'])->name('download');
            Route::get('destroy/{id}', [AssignmentController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'result', 'as' => 'result.'], function () {
            Route::get('/', [ResultController::class, 'index'])->name('index')->middleware('student');
            Route::get('/view/midterm', [ResultController::class, 'midtermIndex'])->name('midtermIndex')->middleware('student');
            Route::get('/view/results', [ResultController::class, 'viewResults'])->name('view.results');

            Route::post('/', [ResultController::class, 'batchExamUpload'])->name('store');

            Route::get('primary/show/{student}', [ResultController::class, 'primaryShow'])->name('primary.show');
            Route::get('midterm/show/{student}', [ResultController::class, 'midtermShow'])->name('midterm.show');
            Route::get('show/{student}', [ResultController::class, 'show'])->name('show');
            Route::get('edit/{result}', [ResultController::class, 'edit'])->name('edit');
            Route::get('create', [ResultController::class, 'create'])->name('create');
            Route::get('/singleUpload', [ResultController::class, 'singleUpload'])->name('singleUpload');
            // Route::post('/singleUpload', [ResultController::class, 'storeSingleUpload'])->name('storeSingleUpload');
            Route::post('/storeSinglePrimaryUpload', [ResultController::class, 'singlePrimaryUpload'])->name('storeSinglePrimaryUpload');

            Route::get('/midterm/upload', [ResultController::class, 'midTermUpload'])->name('midterm.upload');
            Route::get('/batch/midterm/upload', [ResultController::class, 'batchMidtermUpload'])->name('batch.midterm.upload');

            Route::post('/store/midterm/score', [ResultController::class, 'storeMidTerm'])->name('upload.midterm.score');
            Route::post('/batch/store/midterm/score', [ResultController::class, 'storeBatchMidterm'])->name('upload.batch.midterm.score');


            Route::get('/single/secondary', [ResultController::class, 'secondaryUpload'])->name('secondary.upload');
            Route::post('/store/Single/Secondary/Upload', [ResultController::class, 'storeSecondaryUpload'])->name('storeSingleSecondaryUpload');

            Route::get('/check/general', [ResultController::class, 'general'])->name('general');
            Route::get('/check/secondary', [ResultController::class, 'secondary'])->name('secondary');
            Route::get('/check/primary', [ResultController::class, 'primary'])->name('primary');
            Route::get('/check/midterm', [ResultController::class, 'midterm'])->name('midterm');
            Route::get('/psychomotor/get', [ResultController::class, 'psychomotor'])->name('psychomotor.get');
            Route::post('/psychomotor/upload', [ResultController::class, 'psychomotorUpload'])->name('psychomotor.upload');
            Route::post('/cognitive/upload', [ResultController::class, 'cognitiveUpload'])->name('cognitive.upload');

            Route::get('/affective/get', [ResultController::class, 'affective'])->name('affective.get');
            Route::post('/affective/upload', [ResultController::class, 'affectiveUpload'])->name('affective.upload');
            Route::get('/publish/cummulative', [ResultController::class, 'publish']);
            Route::get('/primary/publish/cummulative', [ResultController::class, 'primaryPublish'])->name('primary.publish');
            Route::get('/midterm/publish/cummulative', [ResultController::class, 'midtermPublish'])->name('midterm.publish');

            Route::get('/cummulative/get', [ResultController::class, 'cummulative'])->name('cummulative.get');
            Route::get('/verify/pin', [ResultController::class, 'verify']);

            Route::get('/data/midterm', [ResultController::class, 'getMidTermData']);
            Route::delete('/midterm/delete/{session}/{term}/{student}/{subject}', [ResultController::class, 'midtermDeleteSubject']);
            Route::delete('/exam/delete/{session}/{term}/{student}/{subject}', [ResultController::class, 'examDeleteSubject']);

            Route::get('/subject/broadsheet', [ResultController::class, 'subjectBroadsheet'])->name('subject.broadsheet');
            Route::get('/class/broadsheet', [ResultController::class, 'classBroadsheet'])->name('class.broadsheet');

            Route::get('/fetch/broadsheet/{period_id}/{term_id}/{grade_id}', [ResultController::class, 'broadsheetFetch'])->name('fetch.broadsheet');

            Route::get('/fetch/midterm/{student_id}/{period_id}/{term_id}/{grade_id}', [ResultController::class, 'midtermFetch'])->name('fetch.midterm');
            Route::get('/fetch/exam/{student_id}/{period_id}/{term_id}/{grade_id}', [ResultController::class, 'examFetch'])->name('fetch.exam');

            Route::delete('/midterm/delete/{result_id}', [ResultController::class, 'midtermDelete'])->name('delete.midterm');
            Route::delete('/exam/delete/{result_id}', [ResultController::class, 'examDelete'])->name('delete.exam');

            Route::post('/update/midterm', [ResultController::class, 'midtermUpdate'])->name('update.midterm');
            Route::post('/update/exam', [ResultController::class, 'examUpdate'])->name('update.exam');

            Route::post('/add/midterm', [ResultController::class, 'addMidterm'])->name('add.midterm');
            Route::post('/add/exam', [ResultController::class, 'addExam'])->name('add.exam');

            Route::post('/refresh/result', [ResultController::class, 'refreshResult'])->name('refresh');
            Route::post('/generate/midterm/result', [ResultController::class, 'generateMidtermResult'])->name('generate.midterm');

            Route::post('/excel/midterm/upload', [ResultController::class, 'excelMidTermUpload'])->name('excel.midterm.upload');
            Route::post('/excel/exam/upload', [ResultController::class, 'excelExamUpload'])->name('excel.exam.upload');

            Route::get('/get/students/{grade_id}', [ResultController::class, 'getStudents'])->name('get.students');
            Route::get('/generate/pdf/{grade_id}/{period_id}/{term_id}', [ResultController::class, 'generateMidtermPDF'])->name('generate-pdf.midterm');
            Route::post('/pdf/midterm/generate', [ResultController::class, 'generateSingleMidtermPDF'])->name('midterm.pdf');
            Route::post('/pdf/exam/generate', [ResultController::class, 'generateSingleExamPDF'])->name('exam.pdf');

            Route::get('midterm/check/{grade_id}/{period_id}/{term_id}', [ResultController::class, 'checkMidterm'])->name('check.midterm');
            Route::get('exam/check/{grade_id}/{period_id}/{term_id}', [ResultController::class, 'checkExam'])->name('check.exam');
            Route::get('/single/exam/check/{student_id}/{grade_id}/{period_id}/{term_id}', [ResultController::class, 'singleCheckExam'])->name('check.single.exam');

            Route::get('student/comment/{student_id}/{period_id}/{term_id}', [ResultController::class, 'studentComment'])->name('student.comment');
            Route::get('student/principal/comment/{student_id}/{period_id}/{term_id}', [ResultController::class, 'studentPrincipalComment'])->name('student.principalComment');
            Route::post('/principal/comment', [ResultController::class, 'principalComment'])->name('principal.comment.upload');

            Route::post('/export/excel', [ResultController::class, 'exportExcel'])->name('export.excel');
            Route::get('/{student_id}/subjects', [ResultController::class, 'studentSubject'])->name('student.subjects');

            Route::get('/playgroup/upload', [ResultController::class, 'playgroupUpload'])->name('playgroup.upload');
            Route::get('/playgroup/student/{student_id}/{period_id}/{term_id}', [ResultController::class, 'showPlaygroupResult'])->name('playgroup.student');
            Route::post('/playgroup/store', [ResultController::class, 'storePlayGroupResult'])->name('playgroup.store');

            Route::get('/statistic/show', [ResultController::class, 'resultStatistic'])->name('statistic.show');
            Route::get('/statistic/generate/grade/{grade_id}/{period_id}', [ResultController::class, 'gradeResultStatistic'])->name('statistic.grade.generate');
            Route::get('/statistic/generate/subject/{grade_id}/{period_id}/{subject_id}', [ResultController::class, 'getHighestScoreBySubject'])->name('statistic.subject.generate');

            Route::get('/statistic/generate/class/{grade_id}/{period_id}', [ResultController::class, 'classResultStatistic'])->name('statistic.class.generate');

            Route::post('/download/subject/statistic', [ResultController::class, 'downloadSubjectStatistic'])->name('download.subject.statistic');
            Route::post('/download/grade/statistic', [ResultController::class, 'downloadGradeStatistic'])->name('download.grade.statistic');
            Route::post('/download/class/statistic', [ResultController::class, 'downloadClassStatistic'])->name('download.class.statistic');


            Route::get('playgroup/show/{student}', [ResultController::class, 'playgroupShow'])->name('playgroup.show');
            Route::post('/pdf/playgroup/generate', [ResultController::class, 'generateSinglePlaygroupPDF'])->name('playgroup.pdf');

            Route::post('/update/cummulative/grade', [ResultController::class, 'generateCumulativeScore'])->name('calculate.class.cummulative');
            Route::post('/update/position/grade', [ResultController::class, 'generatePositionScore'])->name('calculate.class.position');
            Route::post('/update/position/score/grade', [ResultController::class, 'generateGradePositionScore'])->name('calculate.student.position');
            Route::get('/sync/position/student/{student_id}/{period_id}/{term_id}', [ResultController::class, 'syncStudentPosition'])->name('student.sync.position');
            Route::get('/single/position/student/{student_id}/{period_id}/{term_id}', [ResultController::class, 'syncStudentSinglePosition'])->name('student.sync.single.position');

            Route::post('/batch/cognitive/upload', [ResultController::class, 'batchCognitiveUpload'])->name('batchcognitive');
            Route::post('/batch/psychomotor/upload', [ResultController::class, 'batchPsychomotorUpload'])->name('batchPsychomotor');
            Route::post('/batch/affective/upload', [ResultController::class, 'batchAffectiveUpload'])->name('batchAffective');

            Route::group(['prefix' => 'cas', 'as' => 'cas.'], function () {
                Route::get('/comment', [ResultController::class, 'classComment'])->name('comment');
                Route::get('/affective', [ResultController::class, 'classAffective'])->name('affective');
                Route::get('/psychomotor', [ResultController::class, 'classPsychomotor'])->name('psychomotor');
            });
        });

        Route::group(['prefix' => 'fee', 'as' => 'fee.'], function () {
            Route::get('/', [FeeController::class, 'index'])->name('index');
            Route::post('/', [FeeController::class, 'store'])->name('store');
            Route::get('show/{student}', [FeeController::class, 'show'])->name('show');
            Route::get('edit/{student}', [FeeController::class, 'edit'])->name('edit');
            Route::get('delete/{fee}/{item}', [FeeController::class, 'deleteFee'])->name('deleteFee');
            Route::get('create', [FeeController::class, 'create'])->name('create');
            Route::put('/{student}', [FeeController::class, 'update'])->name('update');
            Route::post('/update', [FeeController::class, 'update'])->name('updateFee');
            Route::post('assignSubject', [FeeController::class, 'assignSubject'])->name('assignSubject');
            Route::get('/debtors/list/', [FeeController::class, 'debtorList'])->name('debtors.list');
            Route::delete('/debt/delete/{student_id}', [FeeController::class, 'debtDelete'])->name('delete.debt');
            Route::post('/download/debtor/list', [FeeController::class, 'downloadDebtorListPDF'])->name('download.debtor.pdf');
            Route::post('/outstanding/update', [FeeController::class, 'updateOutstanding'])->name('update.outstanding');
            Route::post('/notify/parents', [FeeController::class, 'notifyParents']);
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

        Route::group(['prefix' => 'hairstyle', 'as' => 'hairstyle.'], function () {
            Route::get('/', [HairstyleController::class, 'index'])->name('index');
            Route::post('/', [HairstyleController::class, 'store'])->name('store');
            Route::get('/show/{id}', [HairstyleController::class, 'show'])->name('show');
        });

        Route::group(['prefix' => 'staff', 'as' => 'staff.'], function () {
            Route::get('/', [StaffController::class, 'index'])->name('index');
            Route::post('/', [StaffController::class, 'store'])->name('store');
            Route::get('/bank/list', [StaffController::class, 'bankList']);
            Route::get('/bank/single/{code}', [StaffController::class, 'bankSingle']);
            Route::get('/profile/edit/{id}', [StaffController::class, 'editProfile']);
            Route::post('/update/profile', [StaffController::class, 'updateProfile'])->name('update');
            Route::get('/generate-qrcode/{id}', [StaffController::class, 'generateQr']);
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
            Route::post('/mark', [AttendanceController::class, 'store_attendance'])->name('mark');
            Route::get('/{attendanceId}/student/{studentId}', [AttendanceController::class, 'removeStudent']);
            Route::get('/stat', [AttendanceController::class, 'stat'])->name('stat');
            Route::get('/{id}', [AttendanceController::class, 'showAttendance']);
            Route::get('/students/fetch', [AttendanceController::class, 'fetch']);
            Route::get('/class/{attendance}', [AttendanceController::class, 'classAttendance'])->name('classAttendance');
            Route::get('/daily/all', [AttendanceController::class, 'myAttendance']);
            Route::post('/daily/export', [AttendanceController::class, 'exportAttendance']);
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
            Route::delete('/{id}', [TimetableController::class, 'delete'])->name('delete');
        });

        Route::group(['prefix' => 'calendar', 'as' => 'calendar.'], function () {
            Route::get('/', [TimetableController::class, 'calender'])->name('index');
            Route::get('/generate-pdf', [TimetableController::class, 'generatePDF']);
            Route::post('/assign/duty', [TimetableController::class, 'assign']);
            Route::post('/reassign/duty', [TimetableController::class, 'duty']);
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
            Route::post('/', [FrontendController::class, 'uploadSignaturePost']);
        });

        Route::group(['prefix' => 'payslip', 'as' => 'payslip.'], function () {
            Route::get('/', [PayslipController::class, 'index'])->name('index');
            Route::post('/', [PayslipController::class, 'store'])->name('store');
            Route::get('/review', [PayslipController::class, 'review']);
            Route::get('/{user}', [PayslipController::class, 'single']);
        });

        Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::post('/', [ProductController::class, 'store'])->name('store');
            Route::post('/update', [ProductController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'order', 'as' => 'order.'], function () {
            Route::get('/', [ProductController::class, 'orders'])->name('index')->middleware('admin');
            Route::post('/', [ProductController::class, 'store'])->name('store')->middleware('admin');
            Route::post('/update', [ProductController::class, 'update'])->name('update')->middleware('admin');
            Route::get('/user/orders', [ProductController::class, 'userOrders'])->name('user.orders');
        });
    });

    Route::group(['prefix' => 'appSetting', 'as' => 'appSetting.'], function () {
        Route::post('/mail-config', [ApplicationController::class, 'mail_config'])->name('mail_config');
        Route::get('send-mail', [ApplicationController::class, 'send_mail'])->name('mail.send');
        Route::post('payment-method-update/{payment_method}', [ApplicationController::class, 'payment_update'])->name('payment-method-update');
        Route::get('maintenance-mode', [ApplicationController::class, 'maintenance_mode'])->name('maintenance-mode');
        Route::post('/update-notification', [ApplicationController::class, 'update_notification']);
        Route::post('/mark/format', [ApplicationController::class, 'format']);
        Route::post('/color/format', [ApplicationController::class, 'color']);
        Route::post('/grade/format', [ApplicationController::class, 'grade']);
        Route::post('/affective/domain', [ApplicationController::class, 'domain']);
        Route::post('/create/term/setting', [ApplicationController::class, 'termSetting'])->name('termSetting');
    });

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
            Route::get('/', [MarketController::class, 'index'])->name('index');
            Route::get('/{product}/details', [MarketController::class, 'show'])->name('show');
            Route::get('/cart', [MarketController::class, 'cart'])->name('cart');
            Route::get('/checkout', [MarketController::class, 'checkout'])->name('checkout');
            Route::get('/delete/cart/{item}', [MarketController::class, 'remove'])->name('delete.cartitem');
            Route::get('/update/cart/{item}/{quantity}', [MarketController::class, 'update'])->name('update.cartitem');
        });

        Route::group(['prefix' => 'schoolbus', 'as' => 'schoolbus.'], function () {
            Route::get('/', [SchoolBusController::class, 'index'])->name('index');
            // Route::post('/payment/paystack', [SchoolBusController::class, 'makePayment'])->name('paystack.one-time');
            // Route::get('/paystack/paystack/callback', [SchoolBusController::class, 'callback'])->name('paystack.callback');
        });
    });
});

Route::group(['prefix' => 'teams', 'namespace' => 'Teamwork'], function () {
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
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('login');
        Route::get('/student/login', [LoginController::class, 'showStudentLoginForm'])
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('student/login');
    }

    $limiter = config('fortify.limiters.login');
    $twoFactorLimiter = config('fortify.limiters.two-factor');
    $verificationLimiter = config('fortify.limiters.verification', '6,1');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:' . config('fortify.guard'),
            $limiter ? 'throttle:' . $limiter : null,
        ]));

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Password Reset...
    if (Features::enabled(Features::resetPasswords())) {
        if ($enableViews) {
            Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('password.request');

            Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('password.reset');
        }

        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('password.email');

        Route::post('/reset-password', [NewPasswordController::class, 'store'])
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('password.update');
    }

    // Registration...
    if (Features::enabled(Features::registration())) {
        if ($enableViews) {
            Route::get('/register', [RegisteredUserController::class, 'create'])
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('register');
        }

        Route::post('/register', [RegisteredUserController::class, 'store'])
            ->middleware(['guest:' . config('fortify.guard')]);
    }

    // Email Verification...
    if (Features::enabled(Features::emailVerification())) {
        if ($enableViews) {
            Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
                ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
                ->name('verification.notice');
        }

        Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard'), 'signed', 'throttle:' . $verificationLimiter])
            ->name('verification.verify');

        Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard'), 'throttle:' . $verificationLimiter])
            ->name('verification.send');
    }

    // Profile Information...
    if (Features::enabled(Features::updateProfileInformation())) {
        Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
            ->name('user-profile-information.update');
    }

    // Passwords...
    if (Features::enabled(Features::updatePasswords())) {
        Route::put('/user/password', [PasswordController::class, 'update'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
            ->name('user-password.update');
    }

    // Password Confirmation...
    if ($enableViews) {
        Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')]);
    }

    Route::get('/user/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])
        ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
        ->name('password.confirmation');

    Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])
        ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
        ->name('password.confirm');

    // Two Factor Authentication...
    if (Features::enabled(Features::twoFactorAuthentication())) {
        if ($enableViews) {
            Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('two-factor.login');
        }

        Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
            ->middleware(array_filter([
                'guest:' . config('fortify.guard'),
                $twoFactorLimiter ? 'throttle:' . $twoFactorLimiter : null,
            ]));

        $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
            ? [config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard'), 'password.confirm']
            : [config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')];

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