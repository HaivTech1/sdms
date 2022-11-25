<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\User;
use App\Models\Check;
use App\Models\Leave;
use App\Models\Period;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCheckRequest;
use App\Http\Requests\UpdateCheckRequest;

class CheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.check.index');
    }

    public function CheckStore(Request $request)
    {
        // dd($request);
        if (isset($request->attd)) {
            foreach ($request->attd as $keys => $values) {
                foreach ($values as $key => $value) {
                    if ($student = Student::whereUuid(request('student_uuid'))->first()) {
                        if (
                            !Attendance::whereAttendance_date($keys)
                                ->whereStudent_uuid($key)
                                ->whereType(0)
                                ->first()
                        ) {
                            $data = new Attendance();
                            $data->student_uuid = $key;
                            $emp_req = Student::whereUuid($data->student_uuid)->first();
                            $data->attendance_time = date('H:i:s', strtotime($emp_req->schedules->first()->time_in));
                            $data->attendance_date = $keys;
                            $data->grade_id = $request->grade_id;
                            $data->period_id = Period::whereStatus(1)->pluck('id')[0];
                            $data->term_id = Term::whereStatus(1)->pluck('id')[0];
                            $data->save();
                        }
                    }
                }
            }
        }

        if (isset($request->leave)) {
            foreach ($request->leave as $keys => $values) {
                foreach ($values as $key => $value) {
                    if ($student = Student::whereUuid(request('student_uuid'))->first()) {
                        if (
                            !Leave::whereLeave_date($keys)
                                ->whereStudent_uuid($key)
                                ->whereType(1)
                                ->first()
                        ) {
                            $data = new Leave();
                            $data->student_uuid = $key;
                            $emp_req = Student::whereUuid($data->student_uuid)->first();
                            $data->leave_time = $emp_req->schedules->first()->time_out;
                            $data->leave_date = $keys; 
                            $data->save();
                        }
                    }
                }
            }
        }

        $notification = array (
            'messege' => 'You have successfully submited the attendance',
            'alert-type' => 'success',
            'button' => 'Okay!',
            'title' => 'Success'
        );
        return back()->with($notification);
    }

    public function sheetReport()
    {
        $class = auth()->user()->gradeClassTeacher[0]->id();
        return view('admin.check.sheetreport')->with(['students' => Student::where('grade_id', $class)->get()]);
    }
}
