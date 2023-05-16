<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Scopes\HasActiveScope;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\StudentResource;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $newArray = Student::withoutGlobalScope(new HasActiveScope)->with(['grade', 'house', 'club', 'mother', 'father', 'guardian', 'subjects', 'payments'])->get();
            $students = StudentResource::collection($newArray);
            return response()->json(['status' => true, 'students' => $students], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }

    }

    public function single($id)
    {
        $student = Student::withoutGlobalScope(new HasActiveScope)->findOrFail($id);
        return response()->json(['status' => true, 'student' => new StudentResource($student)], 200);
    }

    public function assignStudent(Request $request)
    {
        try {
            $level = $request->level;
            $gender = $request->gender;
            $user = auth()->user();
        
            if ($user->isSuperAdmin() || $user->isAdmin()) {
                $studentsQuery = Student::withoutGlobalScope(new HasActiveScope)->with([
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

            $student = Student::withoutGlobalScope(new HasActiveScope)->findOrFail($studentId);
            $student->update(['status' => $status === true ? 1 : 0]);
            return response()->json(['status' => true, 'message' => 'Status updated successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $student = Student::withoutGlobalScope(new HasActiveScope)->findOrFail($id);
            $student->delete();
            return response()->json(['status' => true, 'message' => 'Student deleted successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }

    }

    public function assignSubjects(Request $request)
    {
       try {
            DB::transaction( function () use ($request) {
                $students = $request->students;
                $subjectIds = $request->subjects;

                foreach ($students as $studentId) {
                    $student = Student::withoutGlobalScope(new HasActiveScope)->findOrFail($studentId);
                    $student->subjects()->syncWithoutDetaching($subjectIds);
                }
            });

            return response()->json([
                'status' => true,
                'message' => 'Subjects synchronized successfully for the students'
            ], 200);
       } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
       }
    }

    public function deleteSubject($id, $student)
    {
        try {
            $subject = Subject::findOrFail($id);
            $student = Student::withoutGlobalScope(new HasActiveScope)->findOrFail($student);
            $student->subjects()->detach($subject->id());

            return response()->json(['status' => true, 'message' => 'Subject for student deleted successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    
}
// 504F4F