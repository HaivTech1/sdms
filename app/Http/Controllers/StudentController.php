<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Grade;
use App\Models\House;
use App\Models\Student;
use App\Models\Schedule;
use App\Jobs\CreateStudent;
use App\Jobs\UpdateStudent;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }

    public function assignSubject (Request $request)
    {
        $student = Student::findOrFail($request->student_id);
        $student->subjects()->detach();
        $student->subjects()->attach($request->subjects);

        // $notification = array(
        //     'messege' => 'Subject attached Successfully',
        //     'alert-type' => 'success',
        //     'button' => 'Okay!',
        //     'title' => 'Success'
        // );

        // return redirect()->back()->with($notification);
        return response()->json(['status' => 'success', 'message' => 'Subjects synced successfully!'], 200);
    }

    public function promotion()
    {
       return view('admin.student.promotion');
    }
}