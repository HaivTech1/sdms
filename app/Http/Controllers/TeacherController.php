<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Curriculum;
use App\Models\CurriculumTopic;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Subject;
use App\Models\Term;
use App\Models\Week;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct()
    {
        // Require authentication for all methods. Admin-only areas are restricted below.
        $this->middleware(['auth']);

        // Keep existing admin restrictions for management actions not intended for teachers
        $this->middleware('admin')->only(['index','assignClass','assignSubject','showSubject','removeSubject','removeGrade']);
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

    /**
     * List curricula for the authenticated teacher (or admin).
     */
    public function curriculum(Request $request)
    {
        $user = auth()->user();

        $query = Curriculum::with(['grade','subject','period','term']);

        if (!($user->isAdmin() || $user->isSuperAdmin())) {
            $query->where('author_id', $user->id);
        }

        if ($request->filled('search')) {
            $q = $request->get('search');
            $query->where('name', 'like', "%{$q}%");
        }

        $curriculums = $query->orderBy('id','desc')->paginate(20);

        // If this is an AJAX request, return the partial HTML for the list only.
        if ($request->ajax()) {
            return view('teacher.curriculum._list', compact('curriculums'));
        }

        $grades = Grade::with(['subjects'])->get();
        $subjects = Subject::all();
        $periods = Period::all();
        $terms = Term::all();

        return view('teacher.curriculum.index', compact('curriculums', 'grades', "periods", "terms"));
    }

    public function storeCurriculum(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'grade_id' => 'required|exists:grades,id',
            'subject_id' => 'required|exists:subjects,id',
            'period_id' => 'required|exists:periods,id',
            'term_id' => 'required|exists:terms,id',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $curriculum = Curriculum::create(collect($request->only(['name','grade_id','subject_id','period_id','term_id','description']))->toArray());
        $curriculum->authoredBy(auth()->user());
        $curriculum->save();

        return redirect()->route('teacher.curriculum')->with('success', 'Curriculum created');
    }

    public function editCurriculum(Curriculum $curriculum)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) {
            abort(403);
        }

        return view('teacher.curriculum.edit', compact('curriculum'));
    }

    public function updateCurriculum(Request $request, Curriculum $curriculum)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $curriculum->update($data);

        return redirect()->route('teacher.curriculum')->with('success', 'Curriculum updated');
    }

    public function destroyCurriculum(Curriculum $curriculum)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) {
            abort(403);
        }

        $curriculum->delete();
        return back()->with('success', 'Curriculum deleted');
    }

    // --- Topics ---
    public function curriculumTopics(Curriculum $curriculum)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) {
            abort(403);
        }

        $topics = $curriculum->topics()->with('week')->orderBy('week_id')->get();
        $weeks = Week::orderBy('start_date')->get();

        return view('teacher.curriculum.topics', compact('curriculum','topics','weeks'));
    }

    public function storeCurriculumTopic(Request $request, Curriculum $curriculum)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) {
            abort(403);
        }

        $data = $request->validate([
            'week_id' => 'required|exists:weeks,id',
            'title' => 'required|string|max:255',
            'objectives' => 'nullable|string',
            'bloom_level' => 'nullable|string',
            'resources' => 'nullable|string',
        ]);

        $data['curriculum_id'] = $curriculum->id;
        $data['author_id'] = $user->id;

        CurriculumTopic::create($data);

        return back()->with('success', 'Topic added');
    }

    public function editCurriculumTopic(Curriculum $curriculum, CurriculumTopic $topic)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user) && $topic->isAuthoredBy($user))) {
            abort(403);
        }

        $weeks = Week::orderBy('start_date')->get();
        return view('teacher.curriculum.topic_edit', compact('curriculum','topic','weeks'));
    }

    public function updateCurriculumTopic(Request $request, Curriculum $curriculum, CurriculumTopic $topic)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user) && $topic->isAuthoredBy($user))) {
            abort(403);
        }

        $data = $request->validate([
            'week_id' => 'required|exists:weeks,id',
            'title' => 'required|string|max:255',
            'objectives' => 'nullable|string',
            'bloom_level' => 'nullable|string',
            'resources' => 'nullable|string',
        ]);

        $topic->update($data);

        return redirect()->route('teacher.curriculum.topics', $curriculum)->with('success', 'Topic updated');
    }

    public function destroyCurriculumTopic(Curriculum $curriculum, CurriculumTopic $topic)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user) && $topic->isAuthoredBy($user))) {
            abort(403);
        }

        $topic->delete();
        return back()->with('success', 'Topic deleted');
    }
}
