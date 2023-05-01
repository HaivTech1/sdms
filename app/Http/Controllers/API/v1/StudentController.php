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

    public function assignStudent()
    {
        try {

            $user = auth()->user();

            if($user->isSuperAdmin() || $user->isAdmin()) {
                $newArray = Student::with(['grade', 'house', 'club', 'mother', 'father', 'guardian', 'subjects', 'payments'])->get();
                $students = StudentResource::collection($newArray);
            }else{
                $grade  = auth()->user()->gradeClassTeacher;
                $students = $grade->students;
            }
            return response()->json(['status' => true, 'students' => $students], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }
    }
}
