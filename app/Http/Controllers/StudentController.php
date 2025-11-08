<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\User;
use App\Models\Grade;
use App\Models\House;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Cognitive;
use App\Services\SaveCode;
use App\Jobs\UpdateStudent;
use Illuminate\Http\Request;
use App\Models\PrimaryResult;
use App\Scopes\HasActiveScope;
use App\Services\SaveImageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Resources\v1\StudentResource;
use PDF;
use Dompdf\Options;
use App\Traits\NotifiableParentsTrait;
use App\Traits\NumberBroadcast;

use Endroid\QrCode\Builder\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['store', 'getStudentsByClass', 'assignSubject', 'subject',
        'getPerformanceByStudent', 'cognitiveStudents', 'psychomotorStudents', 'affectiveStudents', 'updateProfile',
        "updateUserPassword"]);
    }
    
    
    public function index()
    {
        return view('admin.student.index', [
            'grades' => Grade::orderBy('title')->get(),
            'subjects' => Subject::orderBy('title')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.student.create', [
            'grades' => Grade::all(),
            'houses' => House::all(),
            'clubs' => Club::all(),
            'schedules' => Schedule::all(),
        ]);
    }

 
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $generatedEmail = $this->generateUniqueStudentEmail(
                    $request->first_name,
                    $request->last_name,
                    $request->other_name,
                    $request->dob
                );

                $user = new User([
                    'title' => 'student',
                    'name' => $request->last_name. ' '. $request->first_name. ' '. $request->other_name,
                    'email' => $generatedEmail,
                    'phone_number' => '',
                    'password' => Hash::make('123456'),
                    'type' => '4'
                ]);

                $code = SaveCode::Generator(application('alias').'/', 4, 'reg_no', $user);
                
                $user->reg_no = $code;
                if (!is_null($request->image)) {
                    SaveImageService::UploadImage($request->image, $user, User::TABLE, 'profile_photo_path');
                }else {
                    $user->save();
                }

                $grade = Grade::findOrFail($request->grade_id);

                $student = new Student([
                    'first_name'  => $request->first_name,
                    'last_name'  => $request->last_name,
                    'other_name'  => $request->other_name,
                    'gender'  => $request->gender,
                    'dob'  => $request->dob,
                    'nationality'  => $request->nationality,
                    'state_of_origin'  => $request->state_of_origin,
                    'local_government'  => $request->local_government,
                    'address'  => $request->address,
                    'prev_school'  => $request->prev_school,
                    'prev_class'  => $request->prev_class,
                    'medical_history'  => $request->medical_history,
                    'allergics'  => $request->allergics,
                    'grade_id'  => $request->grade_id,
                    'house_id'  => $request->house_id,
                    'club_id'  => $request->club_id,
                    'status'    => 1,
                    'user_id' => $user->id()
                ]);
                $student->authoredBy(auth()->user());
                $student->save();
                $student->schedules()->sync($request->schedule_id);
                $student->user->roles()->attach([5]);

                if($request->father_name !== null){
                    $father = new Father([
                        'student_uuid'  => $student->id(),
                        'name'  => $request->father_name,
                        'email' =>  $request->father_email,
                        'phone' =>  $request->father_phone,
                        'occupation'  => $request->father_occupation,
                        'office_address' =>  $request->father_office_address,
                    ]);
                    $father->save();
                }

                if($request->mother_name !== null){
                    $mother = new Mother([
                        'student_uuid'  => $student->id(),
                        'name'  => $request->mother_name,
                        'email' =>  $request->mother_email,
                        'phone' =>  $request->mother_phone,
                        'occupation'  => $request->mother_occupation,
                        'office_address' =>  $request->mother_office_address,
                    ]);
                    $mother->save();
                }

                //generate qrcode
                $slugName = Str::slug($student->fullName());
                $qrcode = $this->generateQrcode($slugName, $code);
                $student->qrcode = $qrcode;
                $student->save();

                //assign subject
                $subjectIds = $grade->subjects()->pluck('subjects.id')->all();
                if(count($subjectIds) > 0){
                    $student->subjects()->sync($subjectIds);
                }
            });
            return response()->json(['status' => true, 'message' => 'Student submitted successfully!'], 200);
        } catch (\Throwable $th) {
            info($th);
            DB::rollback();
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }
    }

    private function generateUniqueStudentEmail(?string $firstName, ?string $lastName, ?string $otherName, $dob): string
    {
        $nameParts = array_filter([$lastName, $firstName, $otherName]);
        $localPart = Str::slug(implode('.', $nameParts));

        if (empty($localPart)) {
            $localPart = 'student';
        }

        if (!empty($dob)) {
            try {
                $localPart .= '.' . Carbon::parse($dob)->format('ymd');
            } catch (\Throwable $ex) {
                // ignore parse errors and proceed without dob suffix
            }
        }

        $domain = config('app.student_generated_email_domain', 'gmail.com');
        if (empty($domain)) {
            $domain = 'gmail.com';
        }

        $candidate = strtolower($localPart . '@' . $domain);
        $counter = 1;

        while (User::where('email', $candidate)->exists()) {
            $candidate = strtolower($localPart . '.' . $counter . '@' . $domain);
            $counter++;
        }

        return $candidate;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return view('admin.student.show',[
            'student' => $student
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        return view('admin.student.edit',[
            'student' => $student,
            'grades' => Grade::all(),
            'houses' => House::all(),
            'schedules' => Schedule::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudentRequest  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(StoreStudentRequest $request, Student $student)
    {
        $this->dispatchSync(UpdateStudent::fromRequest($student, $request));

        $notification = array(
            'messege' => 'Student data updated Successfully',
            'alert-type' => 'success',
            'button' => 'Okay!',
            'title' => 'Success'
        );

        return redirect()->back()->with($notification);
    }


    public function assignSubject (Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $student = Student::findOrFail($request->student_id);
                $student->subjects()->attach($request->subjects);
            });
            return response()->json(['status' => true, 'message' => 'Subjects synced successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
        

    }

    public function promotion()
    {
       return view('admin.student.promotion');
    }

    public function getStudentsByClass(Request $request)
    {
        $class = $request->input('class');
        $students = Student::where('grade_id', $class)->get();
        return response()->json($students);
    }

    public function getPerformanceByStudent(Request $request)
    {
        $class_id = $request->input('classId');
        $student_id = $request->input('studentId');
        $term = $request->input('term');
        $session = $request->input('session');

        $results = PrimaryResult::where([
            ['grade_id', '=', $class_id],
            ['student_id', '=', $student_id],
            ['term_id', '=', $term],
            ['period_id', '=', $session]
        ])->get();
        $data = [];

        foreach ($results as $result) {
            $subject = Subject::find($result->subject_id);
            $data[] = [
                'subject' => $subject->title(),
                'ca1' => $result->ca1,
                'ca2' => $result->ca2,
                'ca3' => $result->ca3,
                'project' => $result->pr,
                'exam' => $result->exam,
            ];
        }

        return response()->json($data);
    }


    public function getClassRanking(Request $request)
    {

        $class_id = $request->input('classId');
        $term = $request->input('term');
        $session = $request->input('session');

        $results = PrimaryResult::join('students', 'primary_results.student_id', '=', 'students.uuid')
        ->selectRaw('CONCAT(students.first_name, " ", students.last_name) AS name')
        ->select('students.grade_id', 'students.first_name', 'students.last_name', 'primary_results.student_id')
        ->selectRaw('SUM(ca1 + ca2 + ca3 + pr + exam) AS total')
        ->where('students.grade_id', $class_id)
        ->where('term_id', $term)
        ->where('period_id', $session)
        ->groupBy('primary_results.student_id', 'students.first_name', 'students.last_name', 'students.grade_id')
        ->orderByDesc('total')
        ->get();


        $rankings = [];
        foreach ($results as $result) {
            $rankings[] = [
                'name' => $result->student->last_name . ' ' . $result->student->first_name . ' ' .$result->student->other_name,
                'score' => $result->total,
            ];
        }

        return response()->json(['status' => true, 'data' => $rankings]);
    }

    public function subjects($id)
    {
        $student = Student::findOrFail($id);
        $subjects = $student->subjects;

        return response()->json(['status' => true, 'data' => $subjects]);
    }

    public function destroy(Student $student, Subject $subject)
    {
        $student->scores()->where('subject_id', $subject->id())->delete();
        $subject->delete();
        return response()->json(['success' => true]);
    }

    public function deleteAssignedSubject($studentId, $subjectId)
    {
       try {
         DB::transaction(function () use ($studentId, $subjectId) {
            $student = Student::where('uuid', $studentId)->first();
            $subject = Subject::findOrFail($subjectId);
            $student->subjects()->detach($subject);
         });
         return response()->json([
            'status' => true,
            'message' => 'Subject removed successfully!'
         ], 200);
       } catch (\Throwable $th) {
        info($th);
        return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
        ], 500);
       }
    }

    public function upload(Request $request)
    {
        
        try{

            $studentId = $request->student_id;
            $student = Student::withoutGlobalScope(new HasActiveScope)->findOrFail($studentId);

            if (!is_null($request->image)) {
                File::delete(storage_path('app/' . $student->user->profile_photo_path));
                SaveImageService::UploadImage($request->image, $student->user, User::TABLE, 'profile_photo_path');
            }

            return response()->json([
                'status' => true,
                'message' => "Passport updated successfully!",
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function studentDownloadPdf(Request $request)
    {
        $grade = Grade::findOrFail($request->grade_id);
        $students = Student::where([
            'grade_id' => $request->get('grade_id'),
        ])->get();

    $pdf = PDF::loadHTML('generate.student_list');
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $pdf->getDomPDF()->setOptions($options);
    $pdf->setPaper('a4', 'portrait');
    $pdf->setWarnings(false);
    $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ])
        );
        $pdf->loadView('generate.student_list', ['students' => $students, 'grade' => $grade]);

        return $pdf->download('student_list.pdf');
    }

    public function cognitiveStudents($period, $term)
    {
        $data = Cognitive::where([
            'period_id' => $period,
            'term_id' => $term,
        ])->get();

        $cognitives = [];
        foreach ($data as $value){
            $cognitives[] = [
                'student_id' => $value->student_uuid,
                'comment' => $value->comment,
                'present' => $value->attendance_present
            ];
        }

        return response()->json([
            'status' => true,
            'cognitives' => count($data) > 0 ? $cognitives : [],
        ]);
    }

    public function psychomotorStudents($period, $term)
    {
        $data = \App\Models\Psychomotor::where([
            'period_id' => $period,
            'term_id' => $term,
        ])->get();

        $psychomotors = [];
        foreach ($data as $value){
            $psychomotors[] = [
                'student_id' => $value->student_uuid,
                'title' => $value->title,
                'value' => $value->rate,
            ];
        }

        return response()->json([
            'status' => true,
            'psychomotors' => count($data) > 0 ? $psychomotors : [],
        ]);
    }

    public function affectiveStudents($period, $term)
    {
        $data = \App\Models\Affective::where([
            'period_id' => $period,
            'term_id' => $term,
        ])->get();

        $affectives = [];
        foreach ($data as $value){
            $affectives[] = [
                'student_id' => $value->student_uuid,
                'title' => $value->title,
                'value' => $value->rate,
            ];
        }

        return response()->json([
            'status' => true,
            'affectives' => count($data) > 0 ? $affectives : [],
        ]);
    }

    public function fetchList(Request $request)
    {
        $query = Student::withoutGlobalScope(new HasActiveScope)
            ->with(['user.roles', 'grade', 'subjects'])
            ->when($request->filled('search'), function ($builder) use ($request) {
                $builder->where(function ($nested) use ($request) {
                    $term = trim($request->input('search'));
                    $nested->where('first_name', 'like', "%{$term}%")
                        ->orWhere('last_name', 'like', "%{$term}%")
                        ->orWhere('other_name', 'like', "%{$term}%")
                        ->orWhere('uuid', 'like', "%{$term}%")
                        ->orWhereHas('user', function ($userQuery) use ($term) {
                            $userQuery->where('reg_no', 'like', "%{$term}%");
                        });
                });
            })
            ->when($request->filled('gender') && $request->gender !== 'all', function ($builder) use ($request) {
                $builder->where('gender', $request->input('gender'));
            })
            ->when($request->filled('grade') && $request->grade !== 'all', function ($builder) use ($request) {
                $builder->where('grade_id', $request->input('grade'));
            })
            ->when($request->filled('status') && $request->status !== 'all', function ($builder) use ($request) {
                $status = $request->input('status') === 'active';
                $builder->where('status', $status);
            });

        $orderBy = in_array($request->input('order_by'), ['first_name', 'last_name', 'created_at'], true)
            ? $request->input('order_by')
            : 'created_at';

        $direction = strtolower($request->input('sort_direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        $perPage = (int) $request->input('per_page', 15);
        $perPage = $perPage > 0 ? min($perPage, 100) : 15;

        $students = $query->orderBy($orderBy, $direction)->paginate($perPage);

        $data = $students->getCollection()->map(function (Student $student) {
            $photoPath = $student->image();
            $photoUrl = $photoPath ? asset('storage/' . $photoPath) : asset('noImage.png');

            $roles = $student->user && $student->user->roles
                ? $student->user->roles->pluck('title')->filter()->values()->all()
                : [];

            return [
                'id' => $student->id(),
                'name' => trim($student->lastName() . ' ' . $student->firstName() . ' ' . $student->otherName()),
                'first_name' => $student->firstName(),
                'last_name' => $student->lastName(),
                'other_name' => $student->otherName(),
                'reg_no' => $student->user ? $student->user->code() : null,
                'photo' => $photoUrl,
                'class_name' => optional($student->grade)->title(),
                'grade_id' => $student->grade_id,
                'status' => (bool) $student->status,
                'gender' => $student->gender,
                'joined_at' => $student->createdAt(),
                'roles' => $roles,
                'subjects' => $student->subjects->map(function (Subject $subject) {
                    return [
                        'id' => $subject->id,
                        'title' => $subject->title(),
                    ];
                })->values(),
                'guardian_phone' => optional($student->guardian)->phone,
                'qrcode_path' => $student->qrcode,
                'qrcode_url' => $student->qrcode ? asset('storage/' . $student->qrcode) : null,
            ];
        });

        return response()->json([
            'data' => $data->values(),
            'pagination' => [
                'current_page' => $students->currentPage(),
                'last_page' => $students->lastPage(),
                'per_page' => $students->perPage(),
                'total' => $students->total(),
            ],
        ]);
    }

    public function generateQr($id)
    {
        $student = Student::with(['user'])->where('uuid', $id)->firstOrFail();
        $regNo = $student->id();
        $studentName = $student->fullName();

        // Delete old QR if exists
        if ($student->qrcode && Storage::disk('public')->exists($student->qrcode)) {
            Storage::disk('public')->delete($student->qrcode);
        }

        $slugName = Str::slug($studentName);
        $path = $this->generateQrcode($slugName, $regNo);
        $student->update(['qrcode' => $path]);

        return response()->json([
            'success' => true,
            'message' => "QR code generated successfully.",
            'file' => asset('storage/' . $path),
        ]);
    }

    public function generateQrcode($slugName, $regNo)
    {
        $fileName = $slugName . '-' . time() . '.png';
        $path = "qrcodes/{$fileName}";

        $result = Builder::create()
        ->data($regNo)
        ->size(300)
        ->margin(10)
        ->build();

        Storage::disk('public')->put($path, $result->getString());
        return $path;
    }

    public function sendCredentials($studentuuid)
    {
        try {
            $student = Student::withoutGlobalScope(new HasActiveScope)->where('uuid', $studentuuid)->first();
            $idNumber = $student->user->code();
            $name = $student->last_name." ".$student->first_name. " ".$student->other_name;
            $message = "<p>Your child: $name login credential is: Id Number: ".$idNumber." and password: password123\n Kindly note that the word 'password' should not be removed from the
                numbers.</p>";
            $subject = 'Portal Login Credentials';

            
            try {
                NotifiableParentsTrait::notifyParents($student, $message, $subject);
            } catch (\Throwable $th) {
                info($th->getMessage());
            }

            try {
                $watMessage = "Your child: $name login credential is: \\ \\*Id Number:* ".$idNumber." \\*Password:*password123 \\ \\Kindly note that the word *password* should not be removed from the numbers.";
                NumberBroadcast::notify($student, $watMessage);
            } catch (\Throwable $th) {
               info($th->getMessage());
            }
            
            return response()->json(['status' => true, 'message' => 'Credentials have been sent successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 400);
        }
    }

    public function updateUserPassword(Request $request, $studentUuid)
    {
        try {
            $validated = $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);

            $student = Student::where('uuid', $studentUuid)->firstOrFail();
            $user = $student->user;
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User account not found.'], 404);
            }

            $user->password = Hash::make($validated['password']);
            $user->save();

            return response()->json(['status' => true, 'message' => 'Password updated successfully.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function updateProfile(Request $request, $studentUuid)
    {
        try {
            $validated = $request->validate([
                'first_name'    => 'sometimes|required|string|max:255',
                'last_name'     => 'sometimes|required|string|max:255',
                'other_name'    => 'sometimes|nullable|string|max:255',
                'date_of_birth' => 'sometimes|nullable|date',
            ]);

            $student = Student::where('uuid', $studentUuid)->firstOrFail();

            $student->update($validated);

            return response()->json([
                'status'  => true,
                'message' => 'Profile updated successfully.',
                'student' => new StudentResource($student),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function toggleStatus($studentUuid)
    {
        try {
            $student = Student::withoutGlobalScope(new HasActiveScope)->where('uuid', $studentUuid)->first();
            
            if (!$student) {
                return response()->json([
                    'status' => false,
                    'message' => 'Student not found'
                ], 404);
            }

            $student->status = !$student->status;
            $student->save();

            $statusText = $student->status ? 'activated' : 'deactivated';
            
            return response()->json([
                'status' => true,
                'message' => "Student has been {$statusText} successfully!",
                'new_status' => (bool) $student->status
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

}