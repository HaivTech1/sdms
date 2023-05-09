<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\StudentResource;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $newArray = Student::with(['grade', 'house', 'club', 'mother', 'father', 'guardian', 'subjects', 'payments'])->get();
            $students = StudentResource::collection($newArray);
            return response()->json(['status' => true, 'students' => $students], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }

    }

    public function single($id)
    {
        $student = Student::findOrFail($id);
        return response()->json(['status' => true, 'student' => new StudentResource($student)], 200);
    }

    public function assignStudent(Request $request)
    {
        try {
            $level = $request->level;
            $gender = $request->gender;
            $user = auth()->user();
        
            if ($user->isSuperAdmin() || $user->isAdmin()) {
                $studentsQuery = Student::with([
                    'grade', 'house', 'club', 'mother', 'father', 'guardian', 'subjects', 'payments'
                ]);
            } else {
                $grade = auth()->user()->gradeClassTeacher;
                $studentsQuery = $grade->students()->with([
                    'grade', 'house', 'club', 'mother', 'father', 'guardian', 'subjects', 'payments'
                ]);
            }
        
            $studentsQuery->when($level, function ($query, $level) {
                return $query->where('grade_id', $level);
            })->when($gender, function ($query, $gender) {
                return $query->where('gender', $gender);
            });
        
            $students = StudentResource::collection($studentsQuery->get());
            return response()->json(['status' => true, 'students' => $students], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }
        
    }

    public function toggleStudent(Request $request)
    {
        try {
            $studentId = $request->student_id;
            $status = $request->status;

            $student = Student::findOrFail($studentId);
            $student->update(['status' => $status]);
            return response()->json(['status' => true, 'message' => 'Status updated successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }
    }
}
