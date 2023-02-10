<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['students']);
    }


    public function index()
    {
        return view('admin.teacher.index');
    }

    public function assignClass(Request $request)
    {
        try{
            $teacher = User::findOrFail($request->user_id);
            $teacher->gradeClassTeacher()->detach();
            $teacher->gradeClassTeacher()->attach($request->grade_id);
            return response()->json(['status' => true, 'message' => 'Classes synced successfully!'], 200);
        }catch(\Throwable $th){
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
       
    }

    public function students()
    {
        return view('admin.teacher.students');
    }
}
