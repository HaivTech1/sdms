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
use App\Services\SaveCode;
use App\Jobs\CreateStudent;
use App\Jobs\UpdateStudent;
use Illuminate\Http\Request;
use App\Models\PrimaryResult;
use App\Services\SaveImageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['assignSubject', 'subject', 'getPerformanceByStudent']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.student.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.student.create',[
            'grades' => Grade::all(),
            'houses' => House::all(),
            'clubs' => Club::all(),
            'schedules' => Schedule::all(),
            // 'subjects' => Subject::orderBy('name')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $user = new User([
                    'title' => 'student',
                    'name' => $request->last_name. ' '. $request->first_name. ' '. $request->other_name,
                    'email' => $request->last_name. $request->first_name.'@gmail.com',
                    'phone_number' => '',
                    'password' => Hash::make('password123'),
                    'type' => '4'
                ]);

                $code = SaveCode::Generator('SLNP/', 4, 'reg_no', $user);
                $user->reg_no = $code;
                if (!is_null($request->image)) {
                    SaveImageService::UploadImage($request->image, $user, User::TABLE, 'profile_photo_path');
                }else {
                    $user->save();
                }

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
            });
            return response()->json(['status' => true, 'message' => 'Student submitted successfully!'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }
        // // dd($request);
        
        // $this->dispatchSync(CreateStudent::fromRequest($request));

        // $notification = array(
        //     'messege' => 'Student Created Successfully',
        //     'alert-type' => 'success',
        //     'button' => 'Okay!',
        //     'title' => 'Success'
        // );

        // return redirect()->route('student.index')->with($notification);
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

        return redirect()->route('student.index')->with($notification);
    }


    public function assignSubject (Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $student = Student::findOrFail($request->student_id);
                $student->subjects()->detach();
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

    public function deleteAssignedSubject(Student $student, Subject $subject)
    {
       try {
         DB::transaction(function () use ($student, $subject) {
            $student->subjects()->detach($subject);
         });
         return response()->json([
            'status' => true,
            'message' => 'Subject removed successfully!'
         ], 200);
       } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
        ], 500);
       }
    }
}