<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['students', 'edit', 'update']);
    }


    public function index()
    {
        return view('admin.teacher.index');
    }

    public function assignClass(Request $request)
    {
        try{
            $teacher = User::findOrFail($request->user_id);
            $teacher->gradeClassTeacher()->syncWithoutDetaching($request->grade_id);
            return response()->json(['status' => true, 'message' => 'Classes synced successfully!'], 200);
        }catch(\Throwable $th){
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
       
    }

    public function assignSubject(Request $request)
    {
        try{
            $teacher = User::findOrFail($request->teacher_id);
            $teacher->assignedSubjects()->syncWithoutDetaching($request->subjects);
            return response()->json(['status' => true, 'message' => 'Classes synced successfully!'], 200);
        }catch(\Throwable $th){
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
       
    }

    public function students()
    {
        return view('admin.teacher.students');
    }

    public function edit($id)
    {
        $student = User::findOrFail($id);
        $userStudent = Student::where('user_id',$id)->first();
        return response()->json(['student' => $student, 'user' => $userStudent], 200);
    }

    public function update(Request $request,)
    {
        $user = User::findOrFail($request->id)->update(['reg_no' => $request->reg_no]);
        $student = Student::where('user_id', $request->id)->update([
            'house_id' => $request->house_id,
            'club_id' => $request->club_id
        ]);
        return response()->json(['status' => true, 'message' => 'Information updated successfully!'], 200);
    }

    public function showSubject($id)
    {
        $user = User::findOrFail($id);
        $subjects = $user->assignedSubjects()->get();
        $grades = $user->gradeClassTeacher()->get();

        return response()->json([
            'subjects' => $subjects,
            'grades' => $grades
        ]);
    }

    public function removeSubject ($subjectId, $teacherId)
    {
        $user = User::findOrFail($teacherId);
        $user->assignedSubjects()->detach($subjectId);

        return response()->json([
            'status' => true,
            'message' => 'Subject removed successfully',
        ], 200);
    }

    public function removeGrade ($gradeId, $teacherId)
    {
        $user = User::findOrFail($teacherId);
        $user->gradeClassTeacher()->detach($gradeId);

        return response()->json([
            'status' => true,
            'message' => 'Grade removed successfully',
        ], 200);
    }
}
