<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('admin.attendance.index');
    }

    public function stat()
    {
        return view('admin.attendance.stat');
    }


    public function fetch(Request $request)
    {
        $gradeId = $request->input('gradeId');

        $users = Student::where('grade_id', $gradeId)
                    ->whereNotIn('uuid', function ($query) use ($request) {
                        $query->select('student_id')
                            ->from('attendance_student')
                            ->where('attendance_id', $request->input('attendanceId'));
                    })->get();

        $students = [];
        foreach ($users as $user) {
            $students[] = [
                'id' => $user->id(),
                'name' => $user->lastName() . ' ' . $user->firstName() . ' '. $user->otherName(),
                'reg_no' => $user->user->code()
            ];
        }

        return response()->json([
            'students' => $students,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'grade_id' => ['required'],
                'session_id' => ['required'],
                'term_id' => ['required'],
                'date' => ['required'],
            ]);
    
            DB::transaction(function() use ($request) {
                $attendance = new Attendance([
                    'grade_id' => $request->grade_id,
                    'term_id' => $request->term_id,
                    'period_id' => $request->session_id,
                    'date' => $request->date,
                    'status' => $request->status  === 'on' ? 1 : 0,
                ]);
                $attendance->authoredBy(auth()->user());
                $attendance->save();
            });
    
            return response()->json([
                'status' => true,
                'message' => 'Attendance successfully created!',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'errors' => $th->getMessage(),
            ], 500);
        }

    }

    public function store_attendance(Request $request)
    {
        
        try {
            DB::transaction(function () use ($request){
                $attendance = Attendance::findOrFail($request->attendance_id);
                $studentIds = $request->input('students', []);
                $attendance->students()->attach($studentIds);
            });
            return response()->json(['status' => true, 'message' => 'Attendance recorded successfully.'], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'errors' => $th->getMessage(),
            ], 500);
        }
    }

    public function showAttendance($id)
    {
        $attendance = Attendance::findOrFail($id);
        $users = $attendance->students()->get();

        $students = [];
        foreach ($users as $user) {
            $students[] = [
                'id' => $user->id(),
                'name' => $user->lastName() . ' ' . $user->firstName() . ' '. $user->otherName(),
                'reg_no' => $user->user->code()
            ];
        }

        return response()->json([
            'students' => $students,
        ]);
    }

    public function removeStudent($attendanceId, $studentId)
    {
        $attendance = Attendance::findOrFail($attendanceId);
        $attendance->students()->detach($studentId);

        return response()->json([
            'status' => true,
            'message' => 'Student removed successfully',
        ], 200);
    }
}
