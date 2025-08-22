<?php

namespace App\Http\Controllers;

use App\Jobs\NotifyParentsJob;
use App\Jobs\SendWhatsappJob;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\AttendanceDaily;
use Illuminate\Http\Request;
use App\Models\AttendanceStudent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;
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

    public function storeDailyAttendance(Request $request)
    {
        try {
            $data = $request->all();

            $notifications = [];

            DB::transaction(function () use ($data, &$notifications) {
                foreach ($data as $scan) {
                    if (!isset($scan['student_id']) || !isset($scan['scanned_at'])) {
                        throw new \Exception("Invalid payload: student_id and scanned_at are required.");
                    }

                    $scanId = $scan['student_id'];
                    $student = Student::where('uuid', $scanId)->orWhereHas('user', function ($query) use ($scanId) {
                        $query->where('reg_no', $scanId);
                    })->first();
                    $studentId = $student->id();
                    $scannedAt = Carbon::parse($scan['scanned_at']);
                    $date = $scannedAt->toDateString();

                    $attendance = AttendanceDaily::where('student_id', $studentId)
                        ->where('date', $date)
                        ->first();

                    $note = $scan['note'] ?? null;
                    $action = null;

                    if (!$attendance) {
                        $attendance = new AttendanceDaily([
                            'period_id' => period("id"),
                            'term_id' => term("id"),
                            'student_id' => $studentId,
                            'date' => $date,
                            'am_check_in_at' => $scannedAt,
                            'am_status' => 1,
                            'note' => $note,
                        ]);
                        $attendance->authoredBy(auth()->user());
                        $attendance->save();
                        $action = 'am_check_in';
                    } else {
                        if (is_null($attendance->pm_check_out_at)) {
                            $attendance->update([
                                'pm_check_out_at' => $scannedAt,
                                'pm_status' => 1,
                                'note' => $note ?? $attendance->note,
                            ]);
                            $action = 'pm_check_out';
                        } else {
                            throw new \Exception("Attendance already completed for {$date}.");
                        }
                    }

                    try {
                        if ($student) {
                            $name = trim($student->lastName() . ' ' . $student->firstName() . ' ' . $student->otherName());
                            $when = $scannedAt->format('g:i A, D j M Y');
                            $subject = $action === 'am_check_in' ? 'Attendance Check-In' : 'Attendance Check-Out';

                            $message = "Dear Parent/Guardian,\n\n" .
                                "$name " . ($action === 'am_check_in' ? 'checked in' : 'checked out') .
                                " at $when.\n" .
                                ($note ? "Note: $note\n" : '') .
                                "Thank you.";

                            $watTitle = trim($subject);

                            $watMessage = "*" . $watTitle . "*\n\n" .
                                "$name " . ($action === 'am_check_in' ? 'checked in' : 'checked out') . " at $when.";
                            if ($note) {
                                $watMessage .= "\nNote: $note";
                            }

                            $notifications[] = [
                                'student' => $student,
                                'message' => $message,
                                'watMessage' => $watMessage,
                                'subject' => $subject
                            ];
                        }
                    } catch (\Throwable $inner) {
                        info("Attendance notification build error: " . $inner->getMessage());
                    }
                }
            });

            foreach ($notifications as $n) {
                $student = $n['student'];
                $message = $n['message'];
                $subject = $n['subject'];

                $watMessage = $n['watMessage'];

                $emailJob = new NotifyParentsJob($student, $message, $subject);
                $whatsappJob = new SendWhatsappJob($student, $watMessage, "parent");

                // Dispatch them as a chain
                Bus::chain([
                    $emailJob,
                    $whatsappJob,
                ])->dispatch();
            }

            return response()->json([
                'status' => true,
                'message' => 'Attendance recorded successfully!',
            ], 200);

        } catch (\Throwable $th) {
            info($th);
            return response()->json([
                'status' => false,
                'errors' => $th->getMessage(),
            ], 500);
        }
    }

    public function deleteDailyAttendance($id)
    {
        try {
            $attendance = AttendanceDaily::find($id);

            if (!$attendance) {
                return response()->json([
                    'status' => false,
                    'errors' => 'Daily attendance not found.',
                ], 404);
            }

            $attendance->delete();

            return response()->json([
                'status' => true,
                'message' => 'Daily attendance deleted successfully.',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'errors' => $th->getMessage(),
            ], 500);
        }
    }

    public function myAttendance(Request $request)
    {
        try {
            $user = auth()->user();
            $authorId = $user->id;

            $adminTypes = [];
            if (defined(\App\Models\User::class.'::ADMIN')) {
                $adminTypes[] = \App\Models\User::ADMIN;
            }
            
            if (defined(\App\Models\User::class.'::SUPERADMIN')) {
                $adminTypes[] = \App\Models\User::SUPERADMIN;
            }

            $query = AttendanceDaily::with('student')
            ->when(!in_array($user->type, $adminTypes), fn($q) => $q->where('author_id', $authorId))
            ->orderByDesc('date');

            $date = $request->input('date');
            $from = Carbon::parse($date)->toDateString();
            $query->whereDate('date', '>=', $from);
           

            $records = $query->get()->map(function ($a) {
                return [
                    'id' => $a->id,
                    'date' => $a->date,
                    'am_check_in_at' => optional($a->am_check_in_at)->toDateTimeString(),
                    'pm_check_out_at' => optional($a->pm_check_out_at)->toDateTimeString(),
                    'am_status' => (bool) $a->am_status,
                    'pm_status' => (bool) $a->pm_status,
                    'note' => $a->note,
                    'author_id' => $a->author_id,

                    // ✅ Student details
                    'student' => $a->student ? [
                        'id' => $a->student->id(),
                        'name' => trim($a->student->lastName() . ' ' . $a->student->firstName() . ' ' . $a->student->otherName()),
                        'grade' => optional($a->student->grade)->title(),
                        'reg_no' => optional($a->student->user)->code(),
                    ] : null,
                ];
            });

            return response()->json([
                'status' => true,
                'author' => [
                    'id' => $authorId,
                    'name' => $user->name,
                ],
                'attendance' => $records,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'errors' => $th->getMessage(),
            ], 500);
        }
    }
}