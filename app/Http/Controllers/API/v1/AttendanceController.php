<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UserResource;
use App\Http\Resources\v1\AttendanceResource;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $attendances = Attendance::with(['grade', 'students'])->get();

        $groupedAttendances = $attendances->groupBy(function ($attendance) {
            return $attendance->grade->title;
        })->map(function ($attendances, $levelName) {
            return [
                'name' => $levelName,
                'items' => AttendanceResource::collection($attendances),
            ];
        })->values()->toArray();

        return response()->json(['status' => true, 'data' => $groupedAttendances], 200);

    }

    public function active()
    {
        $attendances = Attendance::where('status', 1)->with(['grade', 'students'])->get();
        return response()->json(['status' => true, 'count' => $attendances->count()], 200);

    }

    public function inactive()
    {
        $attendances = Attendance::where('status', 0)->with(['grade', 'students'])->get();
        return response()->json(['status' => true, 'count' => $attendances->count()], 200);

    }

    public function single($id)
    {
        $attendance = Attendance::with(['grade', 'students'])->findOrFail($id);

        $groupedAttendances = [
            'name' => $attendance->grade->title(),
            'item' => [
                new AttendanceResource($attendance),
            ],
        ];

        return response()->json(['status' => true, 'data' => $groupedAttendances], 200);
    }

    public function delete($id)
    {
        try {
            $attendance = Attendance::findOrFail($id);
            $attendance->delete();
            return response()->json(['status' => true, 'message' => 'Attendance deleted successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function deleteStudent($id, $attendance)
    {
        try {
            $student = Student::find($id);
            $attendance = Attendance::find($attendance);
            $attendance->students()->detach($student->id());

            return response()->json(['status' => true, 'message' => 'Attendance for student deleted successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    
    public function mark_attendance(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $secret = $request->secret;
                $student = Student::whereHas('user', function ($query) use ($secret) {
                    $query->where('reg_no', $secret);
                })->first();
                
                $attendance = Attendance::findOrFail($request->attendance_id);
        
                if ($student->grade_id != $attendance->grade_id) {
                    throw new \Exception('Student does not belong to this grade!');
                }
        
                $attendance->students()->syncWithoutDetaching($student->id());
            });
            return response()->json(['status' => true, 'message' => 'Attendance recorded successfully.'], 200);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'errors' => $th->getMessage(),
            ], 500);
        }
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
                    'grade_id' => $request->grade,
                    'term_id' => $request->term,
                    'period_id' => $request->session,
                    'date' => $request->date,
                    'status' => 1,
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

    public function stat_search(Request $request)
    {
       try {

        $session = $request->session;
        $term = $request->term;
        $grade = $request->grade;
        $search = $request->search;

        $attendanceData = [];

        $attendance = Attendance::when($grade, function($query, $grade) {
            $query->whereHas('grade', function($query) use ($grade) {
                $query->where('id', $grade);
            })
            ->when($session, function($query, $session) {
                $query->whereHas('session', function($query) use ($session) {
                    $query->where('id', $session);
                });
            })
            ->when($term, function($query, $term) {
                $query->whereHas('term', function($query) use ($term) {
                    $query->where('id', $term);
                });
            });
        })->get();

        $students = Student::where('grade_id', $grade)
        ->when($search, function ($query, $search) {
            $query->where('last_name', 'like', '%'.$search.'%')
            ->orWhere('first_name', 'like', '%'.$search.'%')
            ->orWhere('other_name', 'like', '%'.$search.'%');
        })->get();

        $totalAttendances = $attendance->count();
        $totalStudents = $students->count();

        foreach ($students as $student) {
            $presentCount = $student->attendances( function ($query) {
                 $query->where('period_id', $session)->where('term_id', $term)->where('grade_id', $grade);
            })->count();

            $attendanceData[] = [
                'name' => $student->lastName() . ' ' . $student->firstName() . ' ' . $student->otherName(),
                'total_attendance' => $this->totalAttendances,
                'present_count' => $presentCount,
            ];
        }

        return response()->json([
            'status' => true,
            'data' => $attendances->count() > 0 ? $attendanceData : [],
        ], 200);

       } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 422);
       }
    }
}
