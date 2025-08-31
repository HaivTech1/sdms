<?php

namespace App\Http\Controllers;

use App\Jobs\NotifyParentsJob;
use App\Jobs\SendWhatsappJob;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\AttendanceDaily;
use Illuminate\Http\Request;
use App\Models\AttendanceStudent;
use App\Models\User;
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
                    // accept payload keys student_id, user_id or id
                    $identifier =  $scan['user_id'];
                    if (!$identifier || !isset($scan['scanned_at'])) {
                        throw new \Exception("Invalid payload: identifier and scanned_at are required.");
                    }

                    $scannedAt = Carbon::parse($scan['scanned_at']);
                    $date = $scannedAt->toDateString();
                    $note = $scan['note'] ?? null;
                    $action = null;

                    // Resolve as Student first (by uuid or reg_no via user), then fallback to User (staff)
                    $student = Student::where('uuid', $identifier)
                        ->orWhereHas('user', function ($q) use ($identifier) {
                            $q->where('reg_no', $identifier)->orWhere('phone_number', $identifier);
                        })->first();

                    $isStudent = false;
                    $user = null;

                    if ($student) {
                        $isStudent = true;
                        $user = $student->user; // may be null; handle below
                    } else {
                        // try staff/user by reg_no, phone_number or id
                        $user = User::where('reg_no', $identifier)
                                    ->orWhere('phone_number', $identifier)
                                    ->orWhere('id', $identifier)
                                    ->first();
                    }

                    if (!$user) {
                        throw new \Exception("User/Student not found for identifier: {$identifier}");
                    }

                    $userId = $user->id;

                    // find existing daily attendance by user_id and date
                    $attendance = AttendanceDaily::where('user_id', $userId)
                        ->where('date', $date)
                        ->first();

                    if (!$attendance) {
                        $attendance = new AttendanceDaily([
                            'period_id' => period("id"),
                            'term_id' => term("id"),
                            'type' => $isStudent ? AttendanceDaily::TYPE_STUDENT : AttendanceDaily::TYPE_STAFF,
                            'user_id' => $userId,
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
                                'type' => $isStudent ? AttendanceDaily::TYPE_STUDENT : AttendanceDaily::TYPE_STAFF,
                            ]);
                            $action = 'pm_check_out';
                        } else {
                            throw new \Exception("Attendance already completed for {$date}.");
                        }
                    }

                    // Build notification payloads
                    try {
                        if ($isStudent) {
                            $s = $student;
                            $name = trim($s->lastName() . ' ' . $s->firstName() . ' ' . $s->otherName());
                            $when = $scannedAt->format('g:i A, D j M Y');
                            $subject = $action === 'am_check_in' ? 'Attendance Check-In' : 'Attendance Check-Out';

                            $message = "Dear Parent/Guardian,\n\n" .
                                "$name " . ($action === 'am_check_in' ? 'checked in' : 'checked out') .
                                " at $when.\n" .
                                ($note ? "Note: $note\n" : '') .
                                "Thank you.";

                            $watMessage = "*" . $subject . "*\n\n" .
                                "$name " . ($action === 'am_check_in' ? 'checked in' : 'checked out') . " at $when.";
                            if ($note) {
                                $watMessage .= "\nNote: $note";
                            }

                            $notifications[] = [
                                'student' => $s,
                                'message' => $message,
                                'watMessage' => $watMessage,
                                'subject' => $subject
                            ];
                        } else {
                            // staff scan: we persist attendance but do not notify parents or staff here
                            // (Notifications are only intended for student parents)
                            continue;
                        }
                    } catch (\Throwable $inner) {
                        info("Attendance notification build error: " . $inner->getMessage());
                    }
                }
            });

            // Dispatch notifications
            foreach ($notifications as $n) {
                // only student parent notifications are enqueued
                $student = $n['student'];
                $message = $n['message'];
                $subject = $n['subject'];
                $watMessage = $n['watMessage'];
                $emailJob = new NotifyParentsJob($student, $message, $subject);
                $whatsappJob = new SendWhatsappJob($student, $watMessage, "parent");
                Bus::chain([$emailJob, $whatsappJob])->dispatch();
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

            // admins can see all records
            $adminTypes = [User::SUPERADMIN, User::ADMIN];

            $query = AttendanceDaily::with('user.student')
                ->when(! in_array($user->type, $adminTypes), fn($q) => $q->where('author_id', $authorId))
                ->orderByDesc('date');

            $date = $request->input('date');
            $from = $date ? Carbon::parse($date)->toDateString() : now()->toDateString();
            $query->whereDate('date', '>=', $from);
            
            // optional filter: type=student|staff
            $type = $request->input('type');
            if ($type && in_array($type, [AttendanceDaily::TYPE_STUDENT, AttendanceDaily::TYPE_STAFF])) {
                $query->where('type', $type);
            }

            $records = $query->get()->map(function ($a) {
                $user = $a->user;
                $studentModel = $user?->student;

                return [
                    'id' => $a->id,
                    'date' => $a->date,
                    'type' => $a->type,
                    'am_check_in_at' => optional($a->am_check_in_at)->toDateTimeString(),
                    'pm_check_out_at' => optional($a->pm_check_out_at)->toDateTimeString(),
                    'am_status' => (bool) $a->am_status,
                    'pm_status' => (bool) $a->pm_status,
                    'note' => $a->note,
                    'author_id' => $a->author_id,
                    'information' => (function() use ($user, $studentModel) {
                        if ($studentModel) {
                            return [
                                'id' => $studentModel->id(),
                                'name' => trim($studentModel->lastName() . ' ' . $studentModel->firstName() . ' ' . $studentModel->otherName()),
                                'reg_no' => optional($studentModel->user)->code(),
                                'grade' => optional($studentModel->grade)->title(),
                                'is_student' => true,
                            ];
                        }

                        if ($user) {
                            return [
                                'id' => $user->id,
                                'name' => $user->name,
                                'reg_no' => $user->code(),
                                'grade' => null,
                                'is_student' => false,
                            ];
                        }

                        return null;
                    })(),
                ];
            });

            return response()->json([
                'status' => true,
                'attendance' => $records,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'errors' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Export attendance as PDF for a student, staff, or whole grade and send to email.
     * Query params: type=student|staff, user_id, grade_id, date (YYYY-mm-dd)
     */
    public function exportAttendance(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $type = $request->input('type');
        $userId = $request->input('user_id');
        $gradeId = $request->input('grade_id');
        $date = $request->input('date') ? Carbon::parse($request->input('date'))->toDateString() : null;

        $query = AttendanceDaily::with('user.student')
            ->when($date, fn($q) => $q->whereDate('date', $date))
            ->when($type && in_array($type, [AttendanceDaily::TYPE_STUDENT, AttendanceDaily::TYPE_STAFF]), fn($q) => $q->where('type', $type))
            ->orderBy('date');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($gradeId) {
            // join via student relation if present
            $query->whereHas('user.student', fn($q) => $q->where('grade_id', $gradeId));
        }

        $records = $query->get()->map(function ($a) {
            $user = $a->user;
            $studentModel = $user?->student;

            $person = null;
            if ($studentModel) {
                $person = [
                    'id' => $studentModel->id(),
                    'name' => trim($studentModel->lastName() . ' ' . $studentModel->firstName() . ' ' . $studentModel->otherName()),
                    'reg_no' => optional($studentModel->user)->code(),
                    'grade' => optional($studentModel->grade)->title(),
                    'is_student' => true,
                ];
            } elseif ($user) {
                $person = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'reg_no' => $user->code(),
                    'grade' => null,
                    'is_student' => false,
                ];
            }

            return [
                'id' => $a->id,
                'date' => $a->date,
                'type' => $a->type,
                'am_status' => (bool) $a->am_status,
                'pm_status' => (bool) $a->pm_status,
                'note' => $a->note,
                'person' => $person,
            ];
        })->toArray();

        $title = 'Attendance Export';
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdfs.attendance', [
            'title' => $title,
            'records' => $records,
            'type' => $type,
        ])->setPaper('a4', 'portrait');

        $pdfBytes = $pdf->output();

        // Send via email
        $subject = $title . ($date ? " - $date" : '');
        \Illuminate\Support\Facades\Mail::to($request->email)->send(new \App\Mail\SendAttendancePdf('Please find attached the attendance PDF.', $subject, $pdfBytes, "attendance-{$date}.pdf"));

        return response()->json(['status' => true, 'message' => 'PDF generated and emailed.'], 200);
    }
}