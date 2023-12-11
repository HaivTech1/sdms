<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\AttendanceStudent;
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

    public function classAttendance(Attendance $attendance)
    {
        $students = Student::where('grade_id', $attendance->grade_id)->orderBy('last_name')->get();
        // ->whereNotIn('uuid', function ($query) use ($attendance) {
        //     $query->select('student_id')
        //         ->from('attendance_students')
        //         ->where('attendance_id', $attendance->id())
        //         ->where(function ($subquery) {
        //             $subquery->where('morning', false)
        //                     ->orWhere('afternoon', false);
        //         });
        // })

        return view('admin.attendance.class_attendance', [
            'attendance' => $attendance,
            'students' => $students
        ]);
    }


    public function fetch(Request $request)
    {
        $gradeId = $request->input('gradeId');
        $attendanceId = $request->input('attendanceId');

        // $users = Student::where('grade_id', $gradeId)->whereNotIn('uuid', function ($query) use ($request) {
        //                 $query->select('student_id')
        //                     ->from('attendance_student')
        //                     ->where('attendance_id', $request->input('attendanceId'));
        //             })->get();

        $users = Student::with('dailyAttendance')->where('grade_id', $gradeId)->get();
        $current_date = now()->format('d-m-Y');

        $students = [];
        foreach ($users as $user) {
            $attendance = $user->dailyAttendance()->where('attendance_id', $attendanceId)->first();
            $students[] = [
                'id' => $user->id(),
                'name' => $user->lastName() . ' ' . $user->firstName() . ' '. $user->otherName(),
                'reg_no' => $user->user->code(),
                // 'morning' => $attendance?->morning() === '1' ? true : false,
                // 'afternoon' => $attendance?->afternoon() === '1' ? true : false,
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
            $attendance = Attendance::where('id', $request->attendance_id)->first();;
            $grade = $attendance->grade;
            $studentId = $request->student_id;
            $type = $request->attendance_type;
            $is_checked = $request->is_checked;

            $check = AttendanceStudent::where('attendance_id', $attendance->id())->where('student_id', $studentId)->first();

            if ($check) {
                $check->update([
                        $type => $is_checked,
                ]);
            } else {
                AttendanceStudent::create([
                    'attendance_id' => $attendance->id(),
                    'period_id' => period('id'),
                    'term_id' => term('id'),
                    'grade_id' => $grade->id(),
                    'student_id' => $studentId,
                    $type => $is_checked,
                ]);
            }
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
        $attendances = $attendance->markedAttendance()->get();

        $students = [];
        foreach ($attendances as $attendance) {
            $students[] = [
                'id' => $attendance->student->id(),
                'name' => $attendance?->student?->lastName() . ' ' . $attendance?->student?->firstName() . ' '. $attendance?->student?->otherName(),
                'reg_no' => $attendance?->student?->user->code(),
                'morning' => $attendance?->morning() === '1' ? true : false,
                'afternoon' => $attendance?->afternoon() === '1' ? true : false,
            ];
        }

        // dd($students);

        return response()->json([
            'students' => $students,
        ]);
    }

    public function removeStudent($attendanceId, $studentId)
    {
        $attendance = AttendanceStudent::where('attendance_id', $attendanceId)->where('student_id', $studentId)->first();
        $attendance->delete();

        return response()->json([
            'status' => true,
            'message' => 'Student removed successfully',
        ], 200);
    }
}