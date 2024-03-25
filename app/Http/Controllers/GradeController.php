<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;

class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['gradeStudents']);
    }

    public function index()
    {
        return view('admin.grade.index');
    }

    public function gradeStudents(Grade $grade)
    {
        try {
            $students = [];
            $data = $grade->students;  
            foreach ($data as $item) {
                $students[] = [
                    'id' => $item->id(),
                    'name' => $item->firstName() . ' ' . $item->lastName() . ' ' . $item->otherName(),
                ];
            }

            return response()->json([
                'status' => true,
                'student' => $students
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 200);
        }
         
    }
}