<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Grade;
use App\Models\House;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Schedule;
use App\Jobs\CreateStudent;
use App\Jobs\UpdateStudent;
use Illuminate\Http\Request;
use App\Models\PrimaryResult;
use Illuminate\Support\Facades\DB;
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
    public function store(StoreStudentRequest $request)
    {

        // dd($request);
        
        $this->dispatchSync(CreateStudent::fromRequest($request));

        $notification = array(
            'messege' => 'Student Created Successfully',
            'alert-type' => 'success',
            'button' => 'Okay!',
            'title' => 'Success'
        );

        return redirect()->route('student.index')->with($notification);
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
            'houses' => House::all()
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
}