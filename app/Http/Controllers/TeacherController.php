<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Curriculum;
use App\Models\CurriculumTopic;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Term;
use App\Models\Week;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Services\QuestionGeneratorService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

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

        $gradeSubjectsMap = [];
        foreach ($grades as $g) {
            $gradeSubjectsMap[$g->id] = $g->subjects->map(function($s){
                return ['id' => $s->id, 'title' => $s->title];
            })->toArray();
        }

        return view('teacher.curriculum.index', compact('curriculums', 'grades', 'periods', 'terms', 'gradeSubjectsMap'));
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

    public function editCurriculum(Request $request, Curriculum $curriculum)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) {
            abort(403);
        }

        // Prepare supporting lists for the edit form
        $grades = Grade::with(['subjects'])->get();
        $periods = Period::all();
        $terms = Term::all();

        // Prepare gradeSubjectsMap for JS
        $gradeSubjectsMap = [];
        foreach ($grades as $g) {
            $gradeSubjectsMap[$g->id] = $g->subjects->map(function($s){ return ['id' => $s->id, 'title' => $s->title]; })->toArray();
        }

        // If this is an AJAX request, return the form partial so it can be loaded into a modal
        if ($request->ajax()) {
            return view('teacher.curriculum._edit_form', compact('curriculum','grades','periods','terms','gradeSubjectsMap'));
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

        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => 'Curriculum updated']);
        }

        return redirect()->route('teacher.curriculum')->with('success', 'Curriculum updated');
    }

    public function destroyCurriculum(Request $request, Curriculum $curriculum)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) {
            abort(403);
        }

        $curriculum->delete();
        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => 'Curriculum deleted']);
        }

        return back()->with('success', 'Curriculum deleted');
    }

    // --- Topics ---
    public function curriculumTopics(Curriculum $curriculum)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) {
            abort(403);
        }

        // paginate topics so AJAX list supports links
        $topics = $curriculum->topics()->with('week')->withCount('questions')->orderBy('week_id')->paginate(10);
        $weeks = Week::where('term_id', term("id"))->where('period_id', period("id"))->orderBy('start_date')->get();

        if (request()->ajax()) {
            return view('teacher.curriculum._topics_list', compact('curriculum','topics'));
        }

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
            'test_duration' => 'nullable|integer|min:5|max:180',
        ]);

        $data['curriculum_id'] = $curriculum->id;
        $data['author_id'] = $user->id;

        $topic = CurriculumTopic::create($data);

        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => 'Topic added', 'topic' => $topic]);
        }

        return back()->with('success', 'Topic added');
    }

    public function editCurriculumTopic(Curriculum $curriculum, CurriculumTopic $topic)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user) && $topic->isAuthoredBy($user))) {
            abort(403);
        }

        $weeks = Week::orderBy('start_date')->get();
        // If AJAX, return the partial edit form so it can be injected into a modal
        if (request()->ajax()) {
            return view('teacher.curriculum._topic_edit_form', compact('curriculum','topic','weeks'));
        }

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
            'test_duration' => 'nullable|integer|min:5|max:180',
        ]);

        $topic->update($data);

        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => 'Topic updated', 'topic' => $topic]);
        }

        return redirect()->route('teacher.curriculum.topics', $curriculum)->with('success', 'Topic updated');
    }

    public function destroyCurriculumTopic(Curriculum $curriculum, CurriculumTopic $topic)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user) && $topic->isAuthoredBy($user))) {
            abort(403);
        }

        $topic->delete();
        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => 'Topic deleted']);
        }

        return back()->with('success', 'Topic deleted');
    }

    /**
     * Download all saved questions for a curriculum as a question paper PDF.
     * Optional filters: week_id (only that week's topics), order (random|sequential)
     */
    public function downloadCurriculumQuestionsPdf(Request $request, Curriculum $curriculum)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) {
            abort(403);
        }

        $weekId = $request->query('week_id');
        $order = $request->query('order', 'sequential');
        $mode = $request->query('mode', 'questions'); // questions | questions_answers | answers

        $topicsQuery = $curriculum->topics()->with(['questions','week'])->orderBy('week_id');
        if ($weekId) {
            $topicsQuery->where('week_id', $weekId);
        }

        $topics = $topicsQuery->get();

        $questions = [];
        foreach ($topics as $topic) {
            foreach ($topic->questions as $q) {
                $opts = is_array($q->options) ? $q->options : (is_string($q->options) ? json_decode($q->options, true) : []);
                $correctIndex = isset($q->correct_index) ? intval($q->correct_index) : null;
                $correctAnswer = ($correctIndex !== null && isset($opts[$correctIndex])) ? $opts[$correctIndex] : null;

                $questions[] = [
                    'topic_title' => $topic->title,
                    'question' => $q->question,
                    'options' => $opts,
                    'correct_index' => $correctIndex,
                    'correct_answer' => $correctAnswer,
                ];
            }
        }

        if ($order === 'random') {
            shuffle($questions);
        }

        $title = sprintf('%s%s Question Paper', "", optional($curriculum->subject)->title);
        $instruction = $request->instruction || "Answer all questions. Choose the correct option for each question.
        Write your name and Student ID clearly.";

        $data = [
            'title' => $title,
            'school' => [
                'name' => application('name'),
                'address' => application('address'),
                'logo' => asset('storage/' . application('image')),
            ],
            'meta' => [
                'grade' => optional($curriculum->grade)->title,
                'subject' => optional($curriculum->subject)->title,
                'term' => optional($curriculum->term)->title,
                'period' => optional($curriculum->period)->title,
                'generated_at' => now()->format('j M Y g:i A'),
            ],
            'questions' => $questions,
            'instruction' => $instruction,
            'mode' => $mode,
        ];

        $pdf = Pdf::loadView('pdfs.question_paper', $data)
         ->setPaper('A4', 'portrait')
         ->setOption('margin-top', 8)
         ->setOption('margin-bottom', 10)
         ->setOption('margin-left', 8)
         ->setOption('margin-right', 8);

        $safeName = Str::slug($curriculum->name . '-' . ($data['meta']['subject'] ?? 'subject'));
        return $pdf->download($safeName . '.pdf');
    }

    /**
     * Generate questions for a given topic using OpenAI (preview only).
     */
    public function generateTopicQuestions(Request $request, Curriculum $curriculum)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }
        $data = $request->validate([
            'topic_id' => 'required|exists:curriculum_topics,id',
            'count' => 'nullable|integer|min:1|max:50',
            'bloom_level' => 'nullable|string',
            'types' => 'nullable|string',
            'difficulty_mix' => 'nullable|string',
            'model' => 'nullable|string',
            'openaikey' => 'nullable|string',
            'instruction' => 'nullable|string',
        ]);

        $topic = CurriculumTopic::with('week')->findOrFail($data['topic_id']);

        // Prepare human-readable labels for grade, subject, week
        $gradeLabel = optional($curriculum->grade)->title;
        $subjectLabel = optional($curriculum->subject)->title;
        $weekLabel = null;
        if ($topic->week) {
            $weekLabel = $topic->week->name ?? ($topic->week->start_date ? $topic->week->start_date->format('Y-m-d') : $topic->week->id);
        } else {
            $weekLabel = $topic->week_id;
        }

        $options = [
            'grade' => $gradeLabel,
            'subject' => $subjectLabel,
            'week' => $weekLabel,
            'types' => $data['types'] ?? 'MCQ',
            'difficulty_mix' => $data['difficulty_mix'] ?? 'balanced',
            'bloom_level' => $data['bloom_level'] ?? null,
        ];

        if (!empty($data['model'])) {
            $options['model'] = $data['model'];
        }

        if(!empty($data['openaikey'])) {
            $options['openaikey'] = $data['openaikey'];
        }

        if(!empty($data['instruction'])) {
            $options['instruction'] = $data['instruction'];
        }

        $svc = new QuestionGeneratorService();
        try {
            $questions = $svc->generateForTopic($topic->title, strip_tags($topic->objectives), $data['count'] ?? 5, $options);
            return response()->json(['status' => true, 'data' => $questions], 200);
        } catch (\Throwable $th) {
            info($th);
            return response()->json([
                'status' => false, 
                'message' => "There was an error generating the questions,
                Please try again", 
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Persist generated questions (from preview) into the database.
     */
    public function storeGeneratedQuestions(Request $request, Curriculum $curriculum)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'curriculum_topic_id' => 'required|exists:curriculum_topics,id',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_index' => 'required|integer|min:0',
            'questions.*.difficulty' => 'nullable|string',
            'questions.*.bloom_level' => 'nullable|string',
            'questions.*.explanation' => 'nullable|string',
        ]);

        $topic = CurriculumTopic::findOrFail($data['curriculum_topic_id']);

        $saved = [];
        foreach ($data['questions'] as $q) {
            $saved[] = Question::create([
                'curriculum_id' => $curriculum->id,
                'curriculum_topic_id' => $topic->id,
                'author_id' => $user->id,
                'question' => $q['question'],
                'options' => $q['options'],
                'correct_index' => (int)$q['correct_index'],
                'difficulty' => $q['difficulty'] ?? null,
                'bloom_level' => $q['bloom_level'] ?? null,
                'explanation' => $q['explanation'] ?? null,
            ]);
        }

        return response()->json(['status' => true, 'message' => 'Questions saved', 'saved' => $saved], 200);
    }

    /**
     * Save a single question from the preview (per-question save).
     */
    public function storeSingleQuestion(Request $request, Curriculum $curriculum)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'topic_id' => 'required|exists:curriculum_topics,id',
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'correct_index' => 'required|integer|min:0',
            'difficulty' => 'nullable|string',
            'bloom_level' => 'nullable|string',
            'explanation' => 'nullable|string',
        ]);

        // Ensure exactly 4 options: auto-generate distractors when needed
        $options = array_values($data['options']);
        $options = $this->ensureFourOptions($options, (int)$data['correct_index']);

        // normalize correct index
        if ($data['correct_index'] < 0 || $data['correct_index'] >= count($options)) $data['correct_index'] = 0;

        $q = \App\Models\Question::create([
            'curriculum_id' => $curriculum->id,
            'topic_id' => $data['topic_id'],
            'author_id' => $user->id,
            'question' => $data['question'],
            'options' => $options,
            'correct_index' => (int)$data['correct_index'],
            'difficulty' => $data['difficulty'] ?? null,
            'bloom_level' => $data['bloom_level'] ?? null,
            'explanation' => $data['explanation'] ?? null,
        ]);

        return response()->json(['status' => true, 'saved' => $q], 200);
    }

    /**
     * List saved questions for a topic (teacher view).
     */
    public function questions(Curriculum $curriculum, CurriculumTopic $topic)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) abort(403);

        $questions = \App\Models\Question::where('curriculum_topic_id', $topic->id)->orderBy('id','desc')->paginate(20);

        // If AJAX, return partial
        if (request()->ajax()) {
            return view('teacher.curriculum._questions_list', compact('curriculum','topic','questions'));
        }

        return view('teacher.curriculum.questions', compact('curriculum','topic','questions'));
    }

    public function updateQuestion(Request $request, Curriculum $curriculum, Question $question)
    {
        try {
            info($request->all());
        
            $user = auth()->user();
            if (!($user->isAdmin() || $curriculum->isAuthoredBy($user) || $question->author_id == $user->id)) {
                return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
            }

            $data = $request->validate([
                'question' => 'required|string',
                'options' => 'required|array|min:2',
                'correct_index' => 'required|integer|min:0',
                'difficulty' => 'nullable|string',
                'bloom_level' => 'nullable|string',
                'explanation' => 'nullable|string',
            ]);

            $options = array_values($data['options']);
            $options = $this->ensureFourOptions($options, (int)$data['correct_index']);

            if ($data['correct_index'] < 0 || $data['correct_index'] >= count($options)) $data['correct_index'] = 0;

            $question->update([
                'question' => $data['question'],
                'options' => $options,
                'correct_index' => (int)$data['correct_index'],
                'difficulty' => $data['difficulty'] ?? null,
                'bloom_level' => $data['bloom_level'] ?? null,
                'explanation' => $data['explanation'] ?? null,
            ]);

            return response()->json(['status' => true, 'saved' => $question], 200);
        } catch (\Throwable $th) {
            info($th);
            return response()->json(['status' => false, 'message' => 'There was an error saving the question. Please try again.'], 500);
        }
    }

    public function destroyQuestion(Curriculum $curriculum, \App\Models\Question $question)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || $curriculum->isAuthoredBy($user) || $question->author_id == $user->id)) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $question->delete();
        return response()->json(['status' => true, 'message' => 'Deleted'], 200);
    }

    /**
     * Ensure there are exactly 4 options; if fewer, attempt to auto-generate distractors.
     * Very small heuristic: if options count < 4, generate short distractors by rewording or
     * creating plausible alternatives using short templates. This is intentionally conservative.
     *
     * @param array $options
     * @param int $correctIndex
     * @return array
     */
    protected function ensureFourOptions(array $options, int $correctIndex): array
    {
        $opts = array_values(array_filter($options, function($v){ return trim((string)$v) !== ''; }));

        // If there are already 4 or more, trim.
        if (count($opts) >= 4) return array_slice($opts, 0, 4);

        // If there are 0 options, return four placeholders (teacher will edit)
        if (count($opts) === 0) return ['', '', '', ''];

        // Attempt to derive distractors from the base option when it's a short phrase.
        $base = $opts[0];
        $generated = [];
        $baseTrim = trim((string)$base);
        if (strlen($baseTrim) > 0 && str_word_count($baseTrim) <= 4) {
            $variants = [
                "Not {$baseTrim}",
                "A type of {$baseTrim}",
                "Similar to {$baseTrim}",
                "Opposite of {$baseTrim}"
            ];
            foreach ($variants as $v) {
                if (count($opts) + count($generated) >= 4) break;
                $generated[] = $v;
            }
        }

        // fallback generic templates
        $templates = [
            'A different example',
            'An unrelated word',
            'A close but incorrect option',
            'None of the above'
        ];
        foreach ($templates as $t) {
            if (count($opts) + count($generated) >= 4) break;
            $generated[] = $t;
        }

        $merged = array_merge($opts, $generated);
        // If still less than 4, pad with empty strings
        while (count($merged) < 4) $merged[] = '';

        return array_values($merged);
    }
}
