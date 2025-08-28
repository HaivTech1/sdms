<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['gradeStudents']);
    }

    public function index()
    {
        $grades = Grade::withoutGlobalScopes()->paginate(50);
        return view('admin.grade.index', [
            'grades' => $grades,
            'subjects' => Subject::where("status", true)->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required|string|unique:grades,title',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            Grade::create([
                'title' => $data['title'],
                'status' => $data['status'] ?? false,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Grade created successfully!',
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
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

    public function assignGradeSubjects(Request $request, Grade $grade)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'subjects' => 'required|array',
                'subjects.*' => 'exists:subjects,id',
            ]);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $grade->subjects()->sync($data['subjects']);

            return response()->json([
                'status' => true,
                'message' => 'Subjects assigned to grade successfully!',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function gradeSubjects(Grade $grade)
    {
        try {
            $subjects = [];
            $data = $grade->subjects;  
            foreach ($data as $item) {
                $subjects[] = [
                    'id' => $item->id(),
                    'name' => $item->title(),
                ];
            }

            return response()->json([
                'status' => true,
                'subjects' => $subjects
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 200);
        }
         
    }

    public function updateStatus(Request $request, Grade $grade)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'ids' => 'required|array',
                'ids.*' => 'exists:grades,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            Grade::withoutGlobalScopes()->whereIn('id', $data['ids'])->update(['status' => DB::raw('NOT `status`')]);

            return response()->json([
                'status' => true,
                'message' => 'Grade status toggled successfully!',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function deleteAll(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            Grade::withoutGlobalScopes()->whereIn('id', $ids)->delete();
            return response()->json([
                'status' => true,
                'message' => 'Grades deleted successfully!',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function delete(Request $request, Grade $grade)
    {
        try {
            $grade->delete();
            return response()->json([
                'status' => true,   
                'message' => 'Grade deleted successfully!',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}