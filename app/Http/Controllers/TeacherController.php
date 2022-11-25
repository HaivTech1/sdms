<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }


    public function index()
    {
        return view('admin.teacher.index');
    }

    public function assignClass(Request $request)
    {
        $teacher = User::findOrFail($request->user_id);
        $teacher->gradeClassTeacher()->detach();
        $teacher->gradeClassTeacher()->attach($request->grade_id);

        return response()->json(['status' => 'success', 'message' => 'Classes synced successfully!'], 200);
    }
}
