<?php

namespace App\Http\Controllers;

use PDF;
use Excel;
use App\Models\Term;
use App\Models\Week;
use App\Models\Event;
use App\Models\Period;
use App\Models\Grade;
use App\Models\Result;
use App\Models\MidTerm;
use App\Models\Pincode;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Affective;
use App\Models\Cognitive;
use App\Models\PlaygroupResult;
use App\Jobs\CreateResult;
use App\Events\ResultEvent;
use App\Imports\ExamImport;
use App\Models\Cummulative;
use App\Models\Psychomotor;
use Illuminate\Http\Request;
use App\Mail\SendMidtermMail;
use App\Models\PrimaryResult;
use App\Imports\MidtermImport;
use App\Jobs\MidTermResultJob;
use App\Policies\ResultPolicy;
use App\Jobs\CreateSingleResult;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreResultRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SingleResultRequest;
use App\Http\Requests\UpdateResultRequest;
use App\Exports\MidtermResultDataExport;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Policies\UserPolicy;
use App\Traits\{
    NotifiableParentsTrait,
    WhatsappMessageTrait,
    NumberBroadcast
};
use Carbon\Carbon;

class ResultController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $user = auth()->user();
        return view('admin.result.index',[
            'user' => $user,
        ]);
    }

    public function midtermIndex()
    {
        $user = auth()->user();

        return view('admin.result.midterm_index',[
            'user' => $user,
        ]);
    }
    
    public function viewResults()
    {
        return view('admin.result.view_result');
    }
    
    public function singleUpload()
    {
        return view('admin.result.singleUpload');
    }

    public function secondaryUpload()
    {
        return view('admin.result.secondary_upload');
    }

    public function create()
    {
        return view('admin.result.create');
    }

    public function secondary()
    {
        return view('admin.result.check_secondary');
    }

    public function primary()
    {
        return view('admin.result.check_primary');
    }

    public function midterm()
    {
        return view('admin.result.check_midterm');
    }

    public function midTermUpload()
    {
        return view('admin.result.midterm');
    }

    public function batchMidtermUpload()
    {
        return view('admin.result.batch_midterm');
    }

    public function subjectBroadsheet()
    {
        return view('admin.result.broadsheet');
    }
    
    public function classBroadsheet()
    {
        return view('admin.result.classBroadsheet');
    }
    
    public function playgroupUpload()
    {
        return view('admin.result.playgroup.create');
    }
    
    public function resultStatistic()
    {
        return view('admin.result.statistic',[
            'grades' => Grade::all(),
            'terms' => Term::all(),
            'sessions' => Period::all(),
            'subjects' => Subject::all(),
        ]);
    }
    
    public function classComment()
    {
        $grades = UserPolicy::ADMIN ? Grade::all() : auth()->user()->gradeClassTeacher;
        return view('admin.result.class_comment',[
            'grades' => $grades,
            'periods' => Period::all(),
            'terms' => Term::all(),
        ]);
    }
    
    public function batchCognitiveUpload(Request $request)
    {
        try{

            $students = $request->students;

            foreach ($students as $i => $student){

                $check = Cognitive::where([
                    'period_id' => $request->period_id,
                    'term_id' => $request->term_id,
                    'student_uuid' => $student,
                ])->first();  

                if($check){

                    $check->update([
                        'comment' => $request->comments[$i] ?? $check->comment,
                        'attendance_present' => $request->attendances[$i] ?? $check->attendance_present,
                    ]);

                } else{
                    $cog =  new Cognitive([
                        'student_uuid' => $student,
                        'comment' => $request->comments[$i],
                        'attendance_present' => $request->attendances[$i],
                        'period_id' => $request->period_id,
                        'term_id' => $request->term_id,
                    ]);
                    $cog->save();
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Data uploaded successfully'
            ], 200);

        } catch(\Throwable $th){
            info($th);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function classAffective()
    {
        $grades = UserPolicy::ADMIN ? Grade::all() : auth()->user()->gradeClassTeacher;
        return view('admin.result.class_affective', [
            'grades' => $grades,
            'periods' => Period::all(),
            'terms' => Term::all(),
        ]);
    }

    public function classPsychomotor()
    {
        $grades = UserPolicy::ADMIN ? Grade::all() : auth()->user()->gradeClassTeacher;
        return view('admin.result.class_psychomotor',[
            'grades' => $grades,
            'periods' => Period::all(),
            'terms' => Term::all(),
        ]);
    }

    public function batchPsychomotorUpload(Request $request)
    {
        try{
            $students = $request->students;
            $studentsWithoutPsychomotorData = [];
            $namesOfStudentsWithoutPsychomotorData = [];

            foreach ($students as $studentUuid){

                if (!isset($request->psychomotors[$studentUuid])) {
                    $studentsWithoutPsychomotorData[] = $studentUuid;
                    continue;
                }

                $studentPsychomotors = $request->psychomotors[$studentUuid];
                foreach ($studentPsychomotors as $key => $value) {

                    $title = trim($key);

                    $check = Psychomotor::where([
                        'title' => $title,
                        'period_id' => $request->period_id,
                        'term_id' => $request->term_id,
                        'student_uuid' => $studentUuid,
                    ])->first();  

                    if($check){
                        $check->update([
                            'title' => $title,
                            'rate' => $value[0],
                        ]);
                    } else{
                        $psychomotor = new Psychomotor([
                            'title' => $title,
                            'rate' => $value[0],
                            'period_id'     => $request->period_id,
                            'term_id'       => $request->term_id,
                            'student_uuid'        => $studentUuid,
                        ]);
                        $psychomotor->save();
                    }
                }
            }

            if (!empty($studentsWithoutPsychomotorData)) {
                $namesOfStudentsWithoutPsychomotorData = Student::whereIn('uuid', $studentsWithoutPsychomotorData)
                    ->get()
                    ->map(function ($student) {
                        return $student->fullName();
                    })
                    ->toArray();
            }

            return response()->json([
                'status' => true,
                'message' => 'Psychomotor uploaded successfully',
                'no_psychomotor' => [
                    'count' => count($namesOfStudentsWithoutPsychomotorData),
                    'data' => $namesOfStudentsWithoutPsychomotorData
                ],
            ], 200);

        } catch(\Throwable $th){
            info($th);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function batchAffectiveUpload(Request $request)
    {
        try{
            $students = $request->students;
            $studentsWithoutAffectiveData = [];
            $namesOfStudentsWithoutAffectiveData = [];

            foreach ($students as $studentUuid){

                if (!isset($request->affectives[$studentUuid])) {
                    $studentsWithoutAffectiveData[] = $studentUuid;
                    continue;
                }

                $studentAffectives = $request->affectives[$studentUuid];
                foreach ($studentAffectives as $key => $value) {

                    $title = trim($key);

                    $check = Affective::where([
                        'title' => $title,
                        'period_id' => $request->period_id,
                        'term_id' => $request->term_id,
                        'student_uuid' => $studentUuid,
                    ])->first();  

                    if($check){
                        $check->update([
                            'title' => $title,
                            'rate' => $value[0],
                        ]);
                    } else{
                        $affective = new Affective([
                            'title' => $title,
                            'rate' => $value[0],
                            'period_id'     => $request->period_id,
                            'term_id'       => $request->term_id,
                            'student_uuid'        => $studentUuid,
                        ]);
                        $affective->save();
                    }
                }
            }

            if (!empty($studentsWithoutAffectiveData)) {
                $namesOfStudentsWithoutAffectiveData = Student::whereIn('uuid', $studentsWithoutAffectiveData)
                    ->get()
                    ->map(function ($student) {
                        return $student->fullName();
                    })
                    ->toArray();
            }

            return response()->json([
                'status' => true,
                'message' => 'Affective uploaded successfully',
                'no_affective' => [
                    'count' => count($namesOfStudentsWithoutAffectiveData),
                    'data' => $namesOfStudentsWithoutAffectiveData
                ],
            ], 200);

        } catch(\Throwable $th){
            info($th);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function broadsheetFetch($period_id, $term_id, $grade_id)
    {
        $students = Student::where('grade_id', $grade_id)->get();
        $midtermResults = Midterm::where('period_id', $period_id)
                                ->where('term_id', $term_id)
                                ->where('grade_id', $grade_id)
                                ->get();
        $examResults = PrimaryResult::where('period_id', $period_id)
                                    ->where('term_id', $term_id)
                                    ->where('grade_id', $grade_id)
                                    ->get();

        $midtermFormat = get_settings('midterm_format');
        $examFormat = get_settings('exam_format');
        
        $studentResults = [];
        $subjects = [];
        $studentSubject = $students->first()->subjects;

        foreach($studentSubject as $subject){
            $subjects[] = [
                'id' => $subject->id(),
                'name' => $subject->title()
            ];
        }

        foreach ($students as $student) {
            $studentResult = [
                'student_id' => $student->id(),
                'student_name' => $student->last_name . ' ' . $student->first_name . ' ' . $student->other_name,
                'results' => array(),
            ];
            
            // Merge midterm and exam results based on subject
            $mergedResults = $midtermResults->merge($examResults);
            
            foreach ($mergedResults as $result) {
                if ($result->student_id === $student->id()) {
                    $subjectId = $result->subject->id;
                    $subjectTitle = $result->subject->title;
                    
                    if (!isset($studentResult['results'][$subjectId])) {
                        $studentResult['results'][$subjectId] = [
                            'subject_id' => $subjectId,
                            'subject' => $subjectTitle,
                        ];
                    }
                    
                    $resultItem = &$studentResult['results'][$subjectId];
                    
                    // Add midterm scores to the result item
                    if ($result instanceof Midterm) {
                        if (is_array($midtermFormat)) {
                            foreach ($midtermFormat as $midtermKey => $midtermValue) {
                                if (isset($result->$midtermKey)) {
                                    $resultItem[$midtermKey] = $result->$midtermKey;
                                }
                            }
                        }
                    }
                    
                    // Add exam score to the result item
                    if ($result instanceof PrimaryResult) {
                        $resultItem['exam'] = $result->exam;
                    }
                }
            }
            
            $studentResults[] = $studentResult;
        }

        return response([
            'status' => true,
            'results' => $studentResults,
            'midtermFormat' => $midtermFormat,
            'examFormat' => $examFormat,
            'subjects' => $subjects
        ], 200);
    }

    public function midtermFetch($student_id, $period_id, $term_id, $grade_id)
    {
        $user = auth()->user();
        $midtermFormat = get_settings('midterm_format');
        $midterms = MidTerm::where([
            'student_id' => $student_id,
            'period_id' => $period_id,
            'term_id' => $term_id,
            'grade_id' => $grade_id,
        ])->when($user->isTeacher(), function ($query) use ($user) {
            $query->whereHas('subject.teachers', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        })->get();

        $result = [];

        foreach ($midterms as $midterm) {
            $subjectId = $midterm->subject->id();
            $subjectName = $midterm->subject->title();
            $subjectResult = [
                'result_id'     => $midterm->id(),
                'subject_id' => $subjectId,
                'subject_name' => $subjectName,
            ];
        
            if (is_array($midtermFormat)) {
                foreach ($midtermFormat as $midtermKey => $midtermValue) {
                    if (isset($midterm->$midtermKey)) {
                        $subjectResult[$midtermKey] = $midterm->$midtermKey;
                    }
                }
            }
        
            $result[] = $subjectResult;
        }

        // dd($result);

        return response()->json([
            'status' => true,
            'results' => $result,
        ], 200);

    }

    public function examFetch($student_id, $period_id, $term_id, $grade_id)
    {
        $user = auth()->user();
        $examFormat = get_settings('exam_format');
        $exams = PrimaryResult::where([
            'student_id' => $student_id,
            'period_id' => $period_id,
            'term_id' => $term_id,
            'grade_id' => $grade_id,
        ])->when($user->isTeacher(), function ($query) use ($user) {
            $query->whereHas('subject.teachers', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        })->get();

        $result = [];

        foreach ($exams as $exam) {
            $subjectId = $exam->subject->id();
            $subjectName = $exam->subject->title();
            $subjectResult = [
                'result_id'     => $exam->id(),
                'subject_id' => $subjectId,
                'subject_name' => $subjectName,
                'ca1'  => $exam->ca1,
                'ca2' => $exam->ca2,
                'ca3' => $exam->ca3,
                'pr' => $exam->pr,
                'total' => $exam->ca1 + $exam->ca2 + $exam->ca3 + $exam->exam
            ];
        
            if (is_array($examFormat)) {
                foreach ($examFormat as $examKey => $examValue) {
                    if (isset($exam->$examKey)) {
                        $subjectResult[$examKey] = $exam->$examKey;
                    }
                }
            }
        
            $result[] = $subjectResult;
        }

        return response()->json([
            'status' => true,
            'results' => $result,
        ], 200);

    }

    public function midtermDelete($result_id)
    {
        try{
            $midterm = MidTerm::findOrFail($result_id);
            $midterm->delete();

            return response()->json([
                'status' => true,
                'message' => 'Result deleted successfully!'
            ], 200);
        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function midtermUpdate(Request $request)
    {
        try {
            $midterm = MidTerm::findOrFail($request->result_id);
            $midterm->update([
                $request->field => $request->score
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Result updated successfully!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function examDelete($result_id)
    {
        try{
            $exam = PrimaryResult::findOrFail($result_id);
            $exam->delete();

            return response()->json([
                'status' => true,
                'message' => 'Result deleted successfully!'
            ], 200);
        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function examUpdate(Request $request)
    {
        try {
            $exam = PrimaryResult::findOrFail($request->result_id);
            $exam->update([
                $request->field => $request->score
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Result updated successfully!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(Student $student, Request $request)
    {
        
        if($request->term_id == 1){
            $know = (int) $request->term_id +1;
        }elseif($request->term_id == 1){
            $know = (int) $request->term_id +1;
        }else{
            $know = 1;
        }
       
        $nextTermKnow = Term::whereId($know)->first();
        $nextTerm = Event::whereTerm_id($nextTermKnow->id())->wherePeriod_id($request->period_id)->first();
        // dd($nextTerm);
        $date = Event::where('period_id', $request->period_id)
        ->where('term_id', $request->term_id)->where('category', 'bg-success')->get();

        $last_date = count($date) > 0 ? $date[0]->start : date('d-m-y H:i:s');
        $current_date = count($date) > 0 ? $date[0]->end : date('d-m-y H:i:s');
        // dd($current_date);
    
         //NUMBER DAYS BETWEEN TWO DATES CALCULATOR
        $start_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $last_date);
        $end_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $current_date);
        $termDuration = $start_date->diffInDays($end_date);
        // dd($termDuration);

        $result = $student->results->where('period_id', $request->period_id)
                                    ->where('term_id', $request->term_id)
                                    ->where('grade_id', $request->grade_id)
                                    ->where('student_id', $student->id());

        $totalExamScrore = $result->sum('exam') + $result->sum('ca1') + $result->sum('ca2') + $result->sum('ca3');
        $totalSubject = $student->subjects->count();
        $average = $totalExamScrore / $totalSubject;
                                    
        $period = Period::where('id', $request->period_id)->first();
        $term = Term::where('id', $request->term_id)->first();

        $psychomotors = $student->psychomotors->where('period_id', $request->period_id)
        ->where('term_id', $request->term_id);

        $affectives = $student->affectives->where('period_id', $request->period_id)
        ->where('term_id', $request->term_id);

        $attendance = $student->attendance->where('period_id', $request->period_id)
        ->where('term_id', $request->term_id)->count();

        $studentAttendanceAve = count($date) > 0 ? $attendance / $termDuration * 100 : 0;

        $first_term = 1;
        $second_term = 2;
        
        $first_term_cumm = Cummulative::where('term_id', $first_term)->where('student_uuid', $student->id())->where('period_id', $request->period_id)->get();
        $second_term_cumm = Cummulative::where('term_id', $second_term)->where('student_uuid', $student->id())->where('period_id', $request->period_id)->get();
        $studentResults = $student->results->where('term_id', $term->id())->where('period_id', $period->id);


        $newFirst = array();
        foreach ($first_term_cumm as $key => $value) {
            $newFirst[] = [
                'first_term_cummulative' => $value->score,
                'subject_id' => $value->subject_id,
                'grade_id' => $value->grade_id,
                'term_id' => $value->term_id,
                'period_id' => $value->period_id,
            ];
        }

        $newSecond = array();
        foreach ($second_term_cumm as $key => $value) {
            $newSecond[] = [
                'second_term_cummulative' => $value->score,
                'subject_id' => $value->subject_id,
                'grade_id' => $value->grade_id,
                'term_id' => $value->term_id,
                'period_id' => $value->period_id,
            ];
        }

        $newResult = array();
        foreach ($studentResults as $key => $value) {
            $newResult[] = [
                'ca1' => $value->ca1,
                'ca2' => $value->ca2,
                'ca3' => $value->ca3,
                'exam' => $value->exam,
                'total' => $value->ca1 + $value->ca2 + $value->ca3 + $value->exam,
                'grade' => $value->gradeRemark(),
                'remark' => $value->remark(),
                'subject_id' => $value->subject->id(),
                'subject' => $value->subject->title(),
            ];
        }

        $firstTermResult = $newResult;
        $secondTermResult = $this->custom_array_merge($newFirst, $newResult);
        $thirdTermResult = $this->custom_array_merge($secondTermResult, $newSecond);

        if($request->term_id === '1'){
            $results = $firstTermResult;
        }elseif ($request->term_id === '2') {
            $results = $secondTermResult;
        }elseif($request->term_id === '3'){
            $results = $thirdTermResult;
        }

        // dd($nextTerm);
        // if(!$nextTerm){
        //     $notification = array (
        //         'messege' => 'Please set next term resumption first before you can view result!',
        //         'alert-type' => 'info',
        //         'button' => 'Okay!',
        //         'title' => 'Info'
        //     );
        //     return redirect()->route('event.index')->with($notification);
        // }

        return view('admin.result.secondary',[
            'student' => $student,
            'period' => $period,
            'term' => $term,
            'totalExamScrore' => $totalExamScrore,
            'totalSubject' => $totalSubject,
            'average' => $average,
            'psychomotors' => $psychomotors,
            'affectives' => $affectives,
            'attendance' => $attendance,
            'termDuration' => $termDuration,
            'studentAttendanceAve' => $studentAttendanceAve,
            'endOfTerm' => count($date) > 0 ? $current_date->format('d-m-Y') : date('d-m-y'),
            'endOfNextTerm' => !$date->count() == 0 ? $nextTerm->start->format('d-m-Y') : date('d-m-y'),
            'first_term_cumm' => $first_term_cumm,
            'second_term_cumm' => $second_term_cumm,
            'results' => $results
        ]);
    }

    public function primaryShow(Student $student, Request $request)
    {
        $data = $this->generateStudentResultData($student, $request->period_id, $request->term_id);
        return view('admin.result.primary', $data);
    }
    
    private function generateStudentResultData(Student $student, $period_id, $term_id)
    {
        $period = Period::find($period_id);
        $term = Term::find($term_id);
        $grade = $student->grade;
        $termSetting = termSetting($term_id, $period_id);
    
        // Fetch psychomotor and affective records
        $psychomotors = $student->psychomotors->where('period_id', $period_id)->where('term_id', $term_id);
        $affectives = $student->affectives->where('period_id', $period_id)->where('term_id', $term_id);
    
        // Fetch attendance record
        $studentAttendance = Cognitive::where([
            'period_id' => $period_id,
            'term_id' => $term_id,
            'student_uuid' => $student->id()
        ])->first();
    
        // Fetch results **without global scope**
        $first_term_results = ($term_id >= 2) 
            ? $student->primaryResults()->withoutGlobalScopes()->where('term_id', 1)->where('period_id', $period_id)->get() 
            : collect();
    
        $current_term_results = ($term_id >= 1)
            ? $student->primaryResults()->withoutGlobalScopes()->with('subject')
                ->where(['term_id' => $term_id, 'period_id' => $period_id])->get()
            : collect();
    
        // Transform results for first term
        $newFirst = $first_term_results->mapWithKeys(fn($res) => [
            $res->subject_id => [
                'subject_id' => $res->subject_id,
                'subject' => $res->subject->title ?? '',
                'first_term_cummulative' => $res->ca1 + $res->ca2 + $res->ca3 + $res->pr + $res->exam,
            ]
        ])->toArray();
    
        // Transform results for current term (Second Term in this case)
        $newResult = $current_term_results->mapWithKeys(fn($res) => [
            $res->subject_id => [
                'subject_id' => $res->subject->id,
                'subject' => $res->subject->title,
                'ca1' => $res->ca1,
                'ca2' => $res->ca2,
                'ca3' => $res->ca3,
                'pr' => $res->pr,
                'exam' => $res->exam,
                'total' => $res->ca1 + $res->ca2 + $res->ca3 + $res->pr + $res->exam,
            ]
        ])->toArray();
    
        // 🔹 Ensure missing first term subjects are filled from second term
        foreach ($newResult as $subject_id => &$data) {
            if (!isset($newFirst[$subject_id])) {
                $newFirst[$subject_id] = [
                    'subject_id' => $data['subject_id'],
                    'subject' => $data['subject'],
                    'first_term_cummulative' => $data['total'], // Use Second Term total if First Term is missing
                ];
            }
            // Merge first term cumulative into second term data
            $data['first_term_cummulative'] = $newFirst[$subject_id]['first_term_cummulative'];
        }
    
        // 🔹 Merge results correctly based on the term requested
        $results = $newResult;
    
        // 🔹 Sort results with Mathematics and English first
        usort($results, function ($a, $b) {
            $prioritySubjects = ['Mathematics', 'English Language'];
            $aPriority = in_array($a['subject'], $prioritySubjects) ? 0 : 1;
            $bPriority = in_array($b['subject'], $prioritySubjects) ? 0 : 1;
            return $aPriority <=> $bPriority;
        });
    
        // Calculate aggregate and marks obtained
        $marksObtained = array_sum(array_column($results, 'total'));
        $numSubjects = count($results);
        $grandTotal = $numSubjects * 100;
        $aggregate = $numSubjects ? ($marksObtained / $grandTotal) * 100 : 0;
    
        // Calculate total school days open
        $totalSchoolOpen = Week::where('term_id', $term_id)->where('period_id', $period_id)->get()
            ->sum(fn($week) => $this->countWeekdays($week->start_date, $week->end_date));
    
        // Generate student performance comment
        $scores = array_column($results, 'total', 'subject_id');
        $weakness_info = "Dear $student->first_name $student->last_name, you need to work harder next term.";
        $comment = generate_comment($scores, $weakness_info, 0.56, 100, 'examination');
    
        // Calculate student position
        $position = calculateStudentPosition($student->id(), new PrimaryResult(), $period->id(), $term->id(), $student->grade->id());
    
        return compact(
            'student', 'period', 'term', 'psychomotors', 'affectives', 
            'results', 'studentAttendance', 'marksObtained', 'totalSchoolOpen', 
            'aggregate', 'comment', 'termSetting', 'position', 'grade' 
        );
    }

    private function countWeekdays($start, $end)
    {
        $startDate = new \DateTime($start);
        $endDate = new \DateTime($end);
        $interval = new \DateInterval('P1D');
        $duration = new \DatePeriod($startDate, $interval, $endDate);
    
        return collect(iterator_to_array($duration))->filter(fn($date) => $date->format('N') <= 5)->count();
    }


    public function midtermShow(Student $student, Request $request)
    {
        $period = Period::where('id', $request->period_id)->first();
        $term = Term::where('id', $request->term_id)->first();
        $result = $student->midTermResults->where('period_id', $request->period_id)
        ->where('term_id', $request->term_id)
        ->where('grade_id', $request->grade_id)
        ->where('student_id', $student->id());

        $scores = [];

        foreach ($result as $item) {
            $total_score = $item->first_test + $item->second_test;
            $subject_id = $item->subject_id;
            $scores[$subject_id] = $total_score;
        }

        $comment = "";

        $aicomment = AIResultComment::where('term_id', $request->term_id)->where('period_id',
        $request->period_id)->where('result_type', 'midterm')->first();

        if($aicomment){
            $comment = $aicomment->comment;
        }

        return view('admin.result.midterm_show',[
            'student' => $student,
            'period' => $period,
            'term' => $term,
            'results' => $result,
            'comment' => $comment
        ]);
    }

    private function custom_array_merge($newResult, $newFirst) {
        $result = [];
    
        // Convert $newFirst into an associative array using subject_id as key
        $indexedNewFirst = [];
        foreach ($newFirst as $item) {
            $indexedNewFirst[$item['subject_id']] = $item;
        }
    
        // Merge with newResult while preserving all subjects
        foreach ($newResult as $value_1) {
            $subject_id = $value_1['subject_id'];
    
            if (isset($indexedNewFirst[$subject_id])) {
                // Merge if subject exists in both
                $result[] = array_merge($value_1, $indexedNewFirst[$subject_id]);
            } else {
                // Keep the new result if no previous term data
                $result[] = $value_1;
            }
        }
    
        return $result;
    }

    public function storeMidTerm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'period_id'  => ['required'],
            'term_id'    => ['required'],
            'grade_id'   => ['required'],
            'student_id' => ['required'],
        ], [
            "period_id.required" => "Session is required",
            "term_id.required"   => "Session is required",
            "grade_id.required"  => "Please select a class",
            "student_id.required"=> "Please select a student!",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all(),
            ], 400);
        }

        try {
            $midtermFormat = get_settings('midterm_format');

            foreach ($request->subject_id as $i => $subjectId) {
                $midtermData = [
                    'period_id'  => $request->period_id,
                    'term_id'    => $request->term_id,
                    'grade_id'   => $request->grade_id,
                    'student_id' => $request->student_id,
                    'subject_id' => $subjectId,
                ];

                foreach (array_keys($midtermFormat) as $key) {
                    if (isset($request->$key[$i])) {
                        $midtermData[$key] = $request->$key[$i];
                    }
                }

                // Check *per subject*
                $check = MidTerm::where('period_id', $request->period_id)
                    ->where('term_id', $request->term_id)
                    ->where('grade_id', $request->grade_id)
                    ->where('student_id', $request->student_id)
                    ->where('subject_id', $subjectId)
                    ->first();

                if ($check) {
                    // Update instead of blocking everything
                    $check->fill($midtermData);
                    $check->save();
                } else {
                    $midterm = new MidTerm($midtermData);
                    $midterm->authoredBy(auth()->user());
                    $midterm->save();
                }
            }

            return response()->json(['status' => true, 'message' => 'Result uploaded successfully!'], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Error creating result: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function storeBatchMidterm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'period_id'          => ['required'],
            'term_id'              => ['required'],
            'grade_id'              => ['required'],
            'subject_id'              => ['required'],
        ],[
            "period_id.required" => "Session is required",
            "term_id.required" => "Session is required",
            "grade_id.required" => "Please select a class",
            "subject_id.required" => "Please select a Subject!",
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'success' => 'false',
                'message'  => $validator->errors()->all(),
            ], 400);
        }else{
            try{
                foreach ($request->student_id as $i => $studentId) {
                    $check = MidTerm::where('period_id', $request->period_id)
                        ->where('term_id', $request->term_id)
                        ->where('grade_id', $request->grade_id)
                        ->where('subject_id', $request->subject_id)
                        ->where('student_id', $studentId)
                        ->first();

                    $midtermFormat = get_settings('midterm_format');
                    $midtermData = [
                        'period_id' => $request->period_id,
                        'term_id' => $request->term_id,
                        'grade_id' => $request->grade_id,
                        'subject_id' => $request->subject_id,
                        'student_id' => $studentId
                    ];

                    foreach (array_keys($midtermFormat) as $key) {
                        if (isset($request->{$key}[$i])) {
                            $midtermData[$key] = $request->{$key}[$i];
                        }
                    }

                    if ($check) {
                        $check->update($midtermData);
                    } else {
                        $midterm = new MidTerm($midtermData);
                        $midterm->authoredBy(auth()->user());
                        $midterm->save();
                    }
                }

                return response()->json(['status' => true, 'message' => ['Result uploaded successfully!']], 200);
            }catch(\Exception $e){
                return response()->json([
                    'status' => false,
                    'message' => 'Error creating result: ' . $e->getMessage(),
                ], 500);
            }
        }
    }

    public function excelMidTermUpload(Request $request)
    {
        $validations = $this->validate($request, [
            'excel_file' => 'required|mimes:xls,xlsx',
            'student_id' => 'required',
            'period_id' => 'required',
            'term_id' => 'required',
            'grade_id' => 'required',
        ]);
        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|mimes:xls,xlsx',
        ],[
            "excel_file.required" => "Session is required",
            "excel_file.mime" => "Please upload an excel file",
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'success' => false,
                'message'  => $validator->errors()->all(),
            ], 400);
        }else{
            try {
                DB::transaction(function() use ($request) {
                    $path = $request->file('excel_file');
                    Excel::import(new MidtermImport($request), $path);
                });

                return response()->json([
                    'status' => true,
                    'message' => 'Uploaded successfully!',
                ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage(),
                ], 500);
            }
        }
    }

    public function excelExamUpload(Request $request)
    {
        $validations = $this->validate($request, [
            'excel_file' => 'required|mimes:xls,xlsx',
            'student_id' => 'required',
            'period_id' => 'required',
            'term_id' => 'required',
            'grade_id' => 'required',
        ]);
        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|mimes:xls,xlsx',
        ],[
            "excel_file.required" => "Session is required",
            "excel_file.mime" => "Please upload an excel file",
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'success' => false,
                'message'  => $validator->message()->all(),
            ], 400);
        }else{
            try {
                DB::transaction(function() use ($request) {
                    $path = $request->file('excel_file');
                    Excel::import(new ExamImport($request), $path);
                });

                return response()->json([
                    'status' => true,
                    'message' => 'Uploaded successfully!',
                ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage(),
                ], 500);
            }
        }
    }

    public function storeSecondaryUpload(SingleResultRequest $request)
    {
        // dd($request);        
        $check = Result::where('period_id', $request->period_id)
                        ->where('term_id', $request->term_id)
                        ->where('grade_id', $request->grade_id)
                        ->where('student_id', $request->student_id)
                        ->first();

        if ($check) {
            $notification = array (
                'messege' => 'Result for this student already exists!',
                'alert-type' => 'error',
                'button' => 'Okay!',
                'title' => 'Sorry'
            );
    
            return redirect()->back()->with($notification);
        }else {
            $result = $this->dispatchSync(CreateSingleResult::fromRequest($request));
            // dd($result->id());            
            $notification = array (
                'messege' => 'Result uploaded successfully',
                'alert-type' => 'success',
                'button' => 'Okay!',
                'title' => 'Success'
            );

            return redirect()->back()->with($notification);
        }
        
    }
    
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $missingResults = [];

                foreach ($request->student_id as $i => $student_id) {

                    $check = PrimaryResult::where('period_id', $request->period_id)
                    ->where('term_id', $request->term_id)
                    ->where('grade_id', $request->grade_id)
                    ->where('subject_id', $request->subject_id)
                    ->where('student_id', $student_id)
                    ->first();

                    if ($check) {
                        continue;
                    }

                    $midterm = Midterm::where([
                        'period_id' => $request->period_id,
                        'term_id' => $request->term_id,
                        'grade_id' => $request->grade_id,
                        'subject_id' => $request->subject_id,
                        'student_id' => $student_id
                    ])->first();

                    if ($midterm === null) {
                        $student = Student::findOrFail($student_id);
                        $missingResults[] = $student->lastName() . ' ' . $student->firstName() . ' ' . $student->otherName();
                    } else {
                        $result = new PrimaryResult([
                            'period_id'     => $request->period_id,
                            'term_id'       => $request->term_id,
                            'grade_id'      => $request->grade_id,
                            'student_id'    => $student_id,
                            'subject_id'    => $request->subject_id,
                            'ca1'           => $midterm->first_test + $midterm->entry_1 + $midterm->entry_2,
                            'ca2'           => $midterm->ca,
                            'ca3'           => $midterm->class_activity,
                            'pr'            => $midterm->project,
                            'exam'          => $request->exam[$i],
                        ]);
                
                        $result->authoredBy(auth()->user());
                        $result->save();
                    }
                }

                if (!empty($missingResults)) {
                    $missingStudents = implode(', ', $missingResults);
                    throw new \Exception("Results for the following students are missing: $missingStudents");
                }
                
            });

            return response()->json([
                'status' => true,
                'message' => 'Result uploaded successfully!',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error creating result: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function singlePrimaryUpload(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $check = PrimaryResult::where('period_id', $request->period_id)
                    ->where('term_id', $request->term_id)
                    ->where('grade_id', $request->grade_id)
                    ->where('student_id', $request->student_id)
                    ->first();

                if ($check) {
                    // If the result already exists, throw an exception to roll back the transaction
                    throw new \Exception('Result for this student already exists!');
                } else {

                    $midterm = Midterm::where([
                        'period_id' => $request->period_id,
                        'term_id' => $request->term_id,
                        'grade_id' => $request->grade_id,
                        'student_id' => $request->student_id,
                    ])->get();

                    if ($midterm->count() < 1) {
                        throw new \Exception('Please upload midterm result for this student first!');
                    }else{
                        foreach ($request->subject_id as $i => $subject_id) {
                            $midterm_entry = $midterm->where('subject_id', $subject_id)->first();
                            $result = new PrimaryResult([
                                'period_id'     => $request->period_id,
                                'term_id'       => $request->term_id,
                                'grade_id'      => $request->grade_id,
                                'student_id'    => $request->student_id,
                                'subject_id'    => $subject_id,
                                'ca1'           => $midterm_entry->first_test + $midterm_entry->entry_1 + $midterm_entry->entry_2,
                                'ca2'           => $midterm_entry->ca,
                                'ca3'           => $midterm_entry->class_activity,
                                'pr'            => $midterm_entry->project,
                                'exam'          => $request->exam[$i],
                            ]);
                        
                            // Save the new primary result
                            $result->authoredBy(auth()->user());
                            $result->save();
                        }
                    }
                }
            });

            // Return a success response
            return response()->json([
                'status' => true,
                'message' => 'Result uploaded successfully!',
                'data' => [
                    'student_uuid' => $request->student_id, 
                    'period_id' => $request->period_id, 
                    'term_id' => $request->term_id
                ]
            ], 200);
        } catch (\Exception $e) {
            // Roll back the transaction and return an error response
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Error creating result: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function batchExamUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'period_id'          => ['required'],
            'term_id'              => ['required'],
            'grade_id'              => ['required'],
            'subject_id'              => ['required'],
        ],[
            "period_id.required" => "Session is required",
            "term_id.required" => "Session is required",
            "grade_id.required" => "Please select a class",
            "subject_id.required" => "Please select a Subject!",
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'success' => 'false',
                'message'  => $validator->errors()->all(),
            ], 400);
        }else{
            try {
                DB::transaction(function () use ($request) {
                    foreach ($request->student_id as $i => $student) {

                        $checkExam = PrimaryResult::where([
                            'period_id' => $request->period_id,
                            'term_id' => $request->term_id,
                            'grade_id' => $request->grade_id,
                            'subject_id' => $request->subject_id,
                            'student_id' => $student
                        ])->first();

                        $midterm = Midterm::where([
                            'period_id' => $request->period_id,
                            'term_id' => $request->term_id,
                            'grade_id' => $request->grade_id,
                            'subject_id' => $request->subject_id,
                            'student_id' => $student
                        ])->first();

                        $midtermFormat = get_settings('midterm_format');
                        $examFormat = get_settings('exam_format');

                        if(!$checkExam){
                            // if (!$midterm) {
                                
                            // }else{
                            //     $name = $midterm->student->lastName() . ' ' . $midterm->student->firstName(). ' ' . $midterm->student->otherName();
                            //     throw new \Exception("Please upload midterm score for  $name");
                            // }

                            $result = new PrimaryResult([
                                'period_id'     => $request->period_id,
                                'term_id'       => $request->term_id,
                                'grade_id'      => $request->grade_id,
                                'subject_id'    => $request->subject_id,
                                'student_id'    => $student,
                                'ca1'           => $midterm->first_test + $midterm->entry_1 + $midterm->entry_2,
                                'ca2'           => $midterm->ca,
                                'ca3'           => $midterm->class_activity,
                                'pr'            => $midterm->project,
                            ]);

                            // if (is_array($midtermFormat)) {
                            //     foreach ($midtermFormat as $key => $value) {
                            //         if (isset($midterm->$key)) {
                            //             $result->$key = $midterm->$key;
                            //         }
                            //     }
                            // }
                            
                            if (is_array($examFormat) && isset($request->exam[$i])) {
                                foreach ($examFormat as $key => $value) {
                                    $result->$key = $request->exam[$i];
                                }
                            }
                        
                            $result->authoredBy(auth()->user());
                            $result->save();
                        }else{
                            $examData = [
                                'ca1'           => $midterm->first_test + $midterm->entry_1 + $midterm->entry_2,
                                'ca2'           => $midterm->ca,
                                'ca3'           => $midterm->class_activity,
                                'pr'            => $midterm->project,    
                            ];
                           
                            
                            if (is_array($examFormat) && isset($request->exam[$i])) {
                                foreach ($examFormat as $key => $value) {
                                    $examData[$key] = $request->exam[$i];
                                }
                            }
                            $checkExam->update($examData);
                        }
                       
                    }
                });
                
                return response()->json([
                    'status' => true,
                    'message' => 'Result uploaded successfully!',
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Error creating result: ' . $e->getMessage(),
                ], 500);
            }
        }

    }

    public function addMidterm(Request $request)
    {
        try{
            $studentId = $request->student_id;
            $format = $request->format;

            $student = Student::findOrFail($studentId);

            $check = MidTerm::where('period_id', $request->period_id)
            ->where('term_id', $request->term_id)
            ->where('grade_id', $student->grade->id())
            ->where('subject_id', $request->subject_id)
            ->where('student_id', $student->id())
            ->first();

            if ($check) {
                return response()->json([
                    'status' => false,
                    'message' => 'Result already exists in the database! Please try editing the result.',
                ], 500);
            }else {
                $midtermFormat = get_settings('midterm_format');

                $midtermData = [
                    'period_id' => $request->period_id,
                    'term_id' => $request->term_id,
                    'grade_id' => $student->grade->id(),
                    'subject_id' => $request->subject_id,
                    'student_id' => $student->id(),
                ];
                
                foreach (array_keys($midtermFormat) as $key) {
                    if (isset($request->{$key})) {
                        $midtermData[$format] = $request->{$key};
                    }
                }
                
                $midterm = new MidTerm($midtermData);
                $midterm->authoredBy(auth()->user());
                $midterm->save();
            }

            return response()->json(['status' => true, 'message' => ['Result uploaded successfully!']], 200);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Error creating result: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function addExam (Request $request)
    {
        try{
            $studentId = $request->student_id;
            $format = $request->format;

            $student = Student::findOrFail($studentId);

            $midterm = Midterm::where([
                'period_id' => $request->period_id,
                'term_id' => $request->term_id,
                'grade_id' => $student->grade->id(),
                'subject_id' => $request->subject_id,
                'student_id' => $student->id()
            ])->first();

            $check = PrimaryResult::where('period_id', $request->period_id)
            ->where('term_id', $request->term_id)
            ->where('grade_id', $student->grade->id())
            ->where('subject_id', $request->subject_id)
            ->where('student_id', $student->id())
            ->first();

            if ($check) {
                return response()->json([
                    'status' => false,
                    'message' => 'Result already exists in the database! Please try editing the result.',
                ], 500);
            }else {
                $examFormat = get_settings('exam_format');
                $midtermFormat = get_settings('midterm_format');

                $examData = [
                    'period_id' => $request->period_id,
                    'term_id' => $request->term_id,
                    'grade_id' => $student->grade->id(),
                    'subject_id' => $request->subject_id,
                    'student_id' => $student->id(),
                    'ca1'           => $midterm->first_test + $midterm->entry_1 + $midterm->entry_2,
                    'ca2'           => $midterm->ca,
                    'ca3'           => $midterm->class_activity,
                    'pr'            => $midterm->project,
                ];
                
                // if (is_array($midtermFormat)) {
                //     foreach ($midtermFormat as $key => $value) {
                //         if (isset($midterm->$key)) {
                //             $examData[$key] = $midterm->$key;
                //         }
                //     }
                // }

                foreach (array_keys($examFormat) as $key) {
                    if (isset($request->{$key})) {
                        $examData[$format] = $request->{$key};
                    }
                }
                
                $exam = new PrimaryResult($examData);
                $exam->authoredBy(auth()->user());
                $exam->save();
            }

            return response()->json(['status' => true, 'message' => ['Result uploaded successfully!']], 200);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Error creating result: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    public function psychomotor(Request $request)
    {
        $check = Psychomotor::where('student_uuid', $request->student_uuid)
            ->where('period_id', $request->period_id)
            ->where('term_id', $request->term_id)->get();

            return response()->json(['status' => 'success', 'data' => $check]); 
    }

    public function psychomotorUpload(Request $request)
    {
        $check = Psychomotor::where('student_uuid', $request->student_uuid)
            ->where('period_id', $request->period_id)
            ->where('term_id', $request->term_id)->get();


            try {
                DB::transaction(function () use ($request, $check) {
                    if (count($check) > 0) {
                        throw new \Exception('Psychomotor already exist!');
                    }else{
                        for ($i = 0; $i < count($request->title); $i++) { 
                            $psychomotor = new Psychomotor([
                                'title' => $request->title[$i],
                                'rate' => $request->rate[$i],
                                'period_id'     => $request->period_id,
                                'term_id'       => $request->term_id,
                                'student_uuid'        => $request->student_uuid,
                            ]);
                            $psychomotor->save();
                        }
                    }
                });

                return response()->json(['status' => true, 'message' => 'Psychomotor saved successfully','data' => [
                    'student_uuid' => $request->student_uuid, 
                    'period_id' => $request->period_id, 
                    'term_id' => $request->term_id
                ]], 200);

            } catch (\Exception $th) {
                DB::rollback();
                return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
            }
         
    }

    public function affective(Request $request)
    {
        $check = Affective::where('student_uuid', $request->student_uuid)
            ->where('period_id', $request->period_id)
            ->where('term_id', $request->term_id)->get();

            return response()->json(['status' => 'success', 'data' => $check]); 
    }

    public function affectiveUpload(Request $request)
    {

        $check = Affective::where('student_uuid', $request->student_uuid)
            ->where('period_id', $request->period_id)
            ->where('term_id', $request->term_id)->get();

            try {
                DB::transaction(function () use ($request, $check) {
                    if (count($check) > 0) {
                        throw new \Exception('Affective domain already exist');
                    }else{
                        for ($i = 0; $i < count($request->title); $i++) { 
                            $psychomotor = new Affective([
                                'title' => $request->title[$i],
                                'rate' => $request->rate[$i],
                                'period_id'     => $request->period_id,
                                'term_id'       => $request->term_id,
                                'student_uuid'        => $request->student_uuid,
                            ]);
                            $psychomotor->save();
                        }
                    }
                });
                return response()->json(['status' => true, 'message' => 'Affective domain saved successfully','data' => [
                    'student_uuid' => $request->student_uuid, 
                    'period_id' => $request->period_id, 
                    'term_id' => $request->term_id
                ]
            ], 200);
            } catch (\Exception $th) {
                DB::rollback();
                return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
            }
         
    }

    public function cognitiveUpload(Request $request)
    {

        $check = Cognitive::where('student_uuid', $request->student_uuid)
            ->where('period_id', $request->period_id)
            ->where('term_id', $request->term_id)->first();

            try {
                if($check){
                    $check->update([
                        'attendance_duration' => $request->attendance_duration,
                        'attendance_present' => $request->attendance_present,
                        'comment' => $request->comment,
                        'period_id'     => $request->period_id,
                        'term_id'       => $request->term_id,
                        'student_uuid'        => $request->student_uuid,
                    ]);
                }else{
                    $cognitive = new Cognitive([
                        'attendance_duration' => $request->attendance_duration,
                        'attendance_present' => $request->attendance_present,
                        'comment' => $request->comment,
                        'period_id'     => $request->period_id,
                        'term_id'       => $request->term_id,
                        'student_uuid'        => $request->student_uuid,
                    ]);
                    $cognitive->save();
                }
                return response()->json(['status' => true, 'message' => 'Comments and attendance saved successfully'], 200);
            } catch (\Exception $th) {
                DB::rollback();
                return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
            }
         
    }

    public function primaryPublish(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $results = PrimaryResult::where('student_id', $request->student_id)->where('term_id', $request->term_id)->where('period_id', $request->period_id)->where('grade_id', $request->grade_id)->get();
                $student = Student::findOrfail($request->student_id);
                $idNumber = $student->user->code();
                $password = 'password123';
                $name = $student->last_name." ".$student->first_name. " ".$student->other_name;
                $subject = 'Examination Report Sheet';

                $period = Period::where('id', $request->period_id)->first();
                $term = Term::where('id', $request->term_id)->first();
                
                $message = $term->title . "-" . $period->title . " $subject for $name is now available download the document attached with this message.";
        
                foreach($results as $result){
                    $result->update(['published' => true]);
                }
                
        
                $check = Cummulative::where('student_uuid', $request->student_id)->where('term_id', $request->term_id)->where('period_id', $request->period_id)->where('grade_id', $request->grade_id)->get();
        
                if(count($check) > 0){
                    foreach($check as $value){
                        $value->delete();
                    }

                    $cum = array();
                    foreach($results as $result){
                        $cummulative = new Cummulative([
                            'subject_id' => $result['subject_id'],
                            'score' => $result->ca1 + $result->ca2 + $result->ca3 + $result->pr + $result->exam, 
                            'student_uuid' => $result['student_id'], 
                            'period_id' => $result['period_id'],
                            'term_id' => $result['term_id'], 
                            'grade_id' => $result['grade_id'], 
                            'author_id' => auth()->id()
                        ]);
                        $cummulative->save();
                    }
                }else{
                    $cum = array();
                    foreach($results as $result){
                        $cummulative = new Cummulative([
                            'subject_id' => $result['subject_id'],
                            'score' => $result->ca1 + $result->ca2 + $result->ca3 + $result->pr + $result->exam, 
                            'student_uuid' => $result['student_id'], 
                            'period_id' => $result['period_id'],
                            'term_id' => $result['term_id'], 
                            'grade_id' => $result['grade_id'], 
                            'author_id' => auth()->id()
                        ]);
                        $cummulative->save();
                    }
            
                }
                
                $path = $this->generateExamResultLink($student, $request->period_id, $request->term_id);
                
                try {
                    NotifiableParentsTrait::notifyParents($student, $message, $subject, $path);
                } catch (\Throwable $th) {
                    info($th->getMessage());
                }

                try {
                    $watMessage = "*" . $term->title . "-" . $period->title . " $subject*\\ \\$name's result is now available download the document attached with this message.";
                    WhatsappMessageTrait::sendParent($student, $watMessage, $path);
                } catch (\Throwable $th) {
                    info("Exam Term Whatsapp Publish Error: " . $th->getMessage());
                }

                if (File::exists($path)) {
                    File::delete($path);
                }
            });
            return response()->json(['status' => true ,'message' => 'Result published successfully!' ], 200);
        } catch (\Exception $th) {
            return response()->json(['status' => false ,'message' => $th->getMessage() ], 200);
        }
    }
    
    public function generateExamResultLink($student, $period_id, $term_id)
    {
        $data = $this->generateStudentResultData($student, $period_id, $term_id);
        $data['student'] = $student;

        $filename = $student->id() . "_exam_report_" . Carbon::today()->format('Y-m-d') . '.pdf';
        $filePath = storage_path('app/public/results' . $filename);

        $pdf = PDF::loadView('admin.result.exam_pdf_result', $data);

        $pdf->save($filePath);
        return $filePath;
    }

    public function midtermPublish(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $results = MidTerm::where('student_id', $request->student_id)->where('term_id', $request->term_id)->where('period_id', $request->period_id)->where('grade_id', $request->grade_id)->get();
                $student = Student::findOrfail($request->student_id);
                $name = $student->fullname();
                $message = "<p> Dear $name, your mid term result is now available on your portal and attached with this mail is a copy of that result; please download the pdf file attached with this message.</p>";
                $subject = 'Midterm Result Notification';
                
                $period = Period::where('id', $request->period_id)->first();
                $term = Term::where('id', $request->term_id)->first();

                $path = $this->generateMidtermResultLink($student, $request->grade_id, $request->period_id, $request->term_id);

                foreach($results as $result){
                    $result->update(['published' => true]);
                }
                
                
                try {
                    NotifiableParentsTrait::notifyParents($student, $message, $subject, $path);
                } catch (\Throwable $th) {
                    info($th->getMessage());
                }
                
                
                try {
                    $watMessage = "*" . $term->title . "-" . $period->title . " $subject*\\ \\$name's result is now available download the document attached with this message.";
                    WhatsappMessageTrait::sendParent($student, $watMessage, $path);
                } catch (\Throwable $th) {
                    info("Mid Term Whatsapp Publish Error: " . $th->getMessage());
                }
                
                if (File::exists($path)) {
                    File::delete($path);
                }
            });

            return response()->json(['status' => true, 'message' => 'Result published successfully.' ], 200);

        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
       

    }
    
    public function generateMidtermResultLink($student, $grade_id, $period_id, $term_id)
    {
        $period = Period::where('id', $period_id)->first();
        $term = Term::where('id', $term_id)->first();
        $grade = Grade::findOrfail($grade_id);

        $result = $student->midTermResults->where('period_id', $period_id)
        ->where('term_id',  $term_id)
        ->where('grade_id',  $grade_id)->all();


        usort($result, function ($a, $b) {
            $mathematicsEnglish = ['Mathematics', 'English Language'];
    
            if (in_array($a->subject->title(), $mathematicsEnglish) && !in_array($b->subject->title(), $mathematicsEnglish)) {
                return -1;
            } elseif (!in_array($a->subject->title(), $mathematicsEnglish) && in_array($b->subject->title(), $mathematicsEnglish)) {
                return 1;
            } else {
                return strcasecmp($a->subject->title(), $b->subject->title());
            }
        });

        $scores = [];

        foreach ($result as $item) {
            $total_score = $item->entry_1 + $item->entry_2 + $item->first_test + $item->ca + $item->class_activity + $item->project;
            $subject_id = $item->subject_id;
            $scores[$subject_id] = $total_score;
        }
            
        $weakness_info = "Dear $student->first_name, based on your current term score, you need to improve in the following subject(s):";
        $commentResult = generate_comment($scores, $weakness_info, 0.5, 60, 'midterm');

            

        $filename = $student->id() . "_midterm_report_" . Carbon::today()->format('Y-m-d') . '.pdf';
        $filePath = storage_path('app/public/results/' . $filename);

        $pdf = Pdf::loadView('admin.result.primary_midterm_pdf_result', [
                'results' => $result,
                'student' => $student,
                'scores' => $scores,
                'comment' => $commentResult,
                'period' => $period,
                'term' => $term
        ]);

        $pdf->save($filePath);
        return $filePath;
    }


    public function cummulative(Request $request)
    {
        $check = Cummulative::where('student_uuid', $request->student_uuid)
            ->where('period_id', $request->period_id)
            ->where('term_id', $request->term_id)->get();

            return response()->json(['status' => 'success', 'data' => $check]); 
    }

    public function verify(Request $request)
    {
        try {
            $code = $request->code;
            $grade = $request->grade;
            $period = $request->period;
            $term = $request->term;

            $user = auth()->user();
            $userCode  = $user->scratchCard->code;
            $pin = Pincode::whereStudent_id(auth()->id())->first();
            
            if (!is_null($pin)) {
                if (Hash::check($code, $userCode))
                {
                    if ($pin->count >= 7) {
                        $pin->user->update(['pincode' => null]);
                        $pin->delete();
                        return response()->json(['status' => 'error', 'message' => 'This pin is not valid anymore. It has been already used.'], 401); 
                    }else{
                        if($pin->count <= 7){
                            if($pin->term_id == $term && $pin->period_id == $period){
                                $pin->update(['count' => $pin->count +1]);
                                return response()->json(['status' => 'success', 'redirectTo' => '/result/primary/show/'.$user->student->id().'?grade_id='.$grade.'&period_id='.$period.'&term_id='.$term, 'message' => 'Please wait while we cummulate your result. You will be redirected shortly!'], 200); 
                            }else{
                                return response()->json(['status' => 'error', 'message' => 'The pin you entered is not valid for this term or session. Please use a new one!'], 500); 
                            }
                        }else{
                            return response()->json(['status' => 'error', 'message' => 'The pin code is not valid. It is already used.'], 401); 
                        }
                    }
                }else{
                    return response()->json(['status' => 'error', 'message' => 'The pin code is not correct! Please try again.'], 401); 
                }
            }else{
                return response()->json(['status' => 'error', 'message' => 'You need to purchase a pin code to check result.'], 401); 
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500); 
        }
        
    }

    public function getMidTermData(Request $request)
    {
        $grade = $request->input('grade_id');
        $period = $request->input('period_id');
        $term = $request->input('term_id');

        $data = Student::when($grade, function($query, $grade) use ($period, $term) {
                $query->whereHas('grade', function($query) use ($grade){
                $query->where('id', $grade);
                })
                ->when($period, function($query) use ($period){
                    $query->whereHas('midTermResults', function($query) use ($period){
                        $query->whereHas('period', function ($query) use ($period){
                            $query->where('id', $period);
                        });
                    });
                })
                ->when($term, function($query) use ($term){
                    $query->whereHas('midTermResults', function($query) use ($term){
                        $query->whereHas('term', function ($query) use ($term){
                            $query->where('id', $term);
                        });
                    });
                });
        })->paginate(10);


        $responseData = array();
        foreach($data as $value){
            $responseData[] = [
                'name' => $value->firstName() . ' ' . $value->lastName(),
                'total_recorded' => $value->midTermResults->where('period_id', $period)->where('term_id', $term)->count(),
            ];
        }
        

        return response()->json($responseData);
    }

    public function midtermDeleteSubject($sessionId, $termId, $studentId, $subjectId)
    {
        $session = Session::findOrFail($sessionId);
        $term = Term::findOrFail($termId);
        $student = Student::findOrFail($studentId);
        $subject = Subject::findOrFail($subjectId);

        $midtermResult = MidtermResult::where('term_id', $term)->where('subject_id', $subject)->where('student_id', $student)->where('period_id', $session)->first();
        $midtermResult->delete();

        return response()->json([
            'status' => true,
            'message' => 'Result deleted successfully'
        ], 200);
    }

    public function examDeleteSubject($sessionId, $termId, $studentId, $subjectId)
    {
        $session = Session::findOrFail($sessionId);
        $term = Term::findOrFail($termId);
        $student = Student::findOrFail($studentId);
        $subject = Subject::findOrFail($subjectId);

        $midtermResult = Result::where('term_id', $term)->where('subject_id', $subject)->where('student_id', $student)->where('period_id', $session)->first();
        $midtermResult->delete();

        return response()->json([
            'status' => true,
            'message' => 'Result deleted successfully'
        ], 200);
    }

    public function refreshResult(Request $request)
    {
        try {
            $grade = $request->grade_id;
            $period = $request->period_id;
            $term = $request->term_id;
        
            $midtermResults = MidTerm::where(['grade_id' => $grade, 'period_id' => $period, 'term_id' => $term])->get();
            $students = Student::where('grade_id', $grade)->get();
        
            if ($midtermResults->isNotEmpty() && $students->isNotEmpty()) {
                DB::transaction(function () use ($midtermResults, $students, $period, $term, $grade) {
                    $midtermFormat = get_settings('midterm_format');
            
                    foreach ($students as $student) {
                        $examResults = PrimaryResult::where([
                            'grade_id' => $grade,
                            'period_id' => $period,
                            'term_id' => $term,
                            'student_id' => $student->id()
                        ])->get();
            
                        if ($examResults->isNotEmpty()) {
                            foreach ($midtermResults as $midtermResult) {
                                if ($midtermResult->student_id === $student->id()) {
                                    $subjectId = $midtermResult->subject_id;
            
                                    $examResult = $examResults->where('subject_id', $subjectId)->first();
            
                                    if ($examResult) {
                                        $examResult['ca1']           = $midtermResult->first_test + $midtermResult->entry_1 + $midtermResult->entry_2;
                                        $examResult['ca2']           = $midtermResult->ca;
                                        $examResult['ca3']           = $midtermResult->class_activity;
                                        $examResult['pr']            = $midtermResult->project;
                                        $examResult->save();
                                    }
                                }
                            }
                        }
                    }
                });
            
                return response()->json([
                    'status' => true,
                    'message' => 'Result refreshed successfully!',
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'No results found for the specified term, session, and class',
                ], 500);
            }
            
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
        
        
    }

    public function getStudents($grade_id)
    {
        $students = Student::where('grade_id', $grade_id)->orderBy('last_name')->get();
        return response()->json($students);
    }


    public function checkMidterm($grade_id, $period_id, $term_id)
    {
        try {
            $data = Student::where('grade_id', $grade_id)->orderBy('last_name', 'asc')->get();
            $students = [];

            foreach($data as $value){
                $students[] = [
                    'id' => $value->id(),
                    'name' => $value->last_name . ' ' . $value->first_name . ' ' . $value->other_name,
                    'recorded_subjects' => $value->midTermResults->where('grade_id', $grade_id)->where('term_id', $term_id)->where('period_id', $period_id)->count(),
                    'publish_state' =>  publishMidState($value->id(), $period_id, $term_id),
                ];
            }

            return response()->json([
                'students' => $students,
                'grade' => $grade_id,
                'period' => $period_id,
                'term' => $term_id,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function checkExam($grade_id, $period_id, $term_id)
    {
        try {

            $grade = Grade::find($grade_id);
            $template = get_settings('result_template');
            $data = Student::where('grade_id', $grade_id)->orderBy('last_name', 'asc')->get();
            $students = [];

            if ($grade->title !== 'Playgroup'){
    
                foreach($data as $value){
                    $students[] = [
                        'id' => $value->id(),
                        'name' => $value->last_name . ' ' . $value->first_name . ' ' . $value->other_name,
                        'recorded_subjects' => $value->primaryResults->where('grade_id', $grade_id)->where('term_id', $term_id)->where('period_id', $period_id)->count(),
                        'publish_state' => publishExamState($value->id(), $period_id, $term_id),
                    ];
                }
            }else{
                foreach($data as $value){
                    $students[] = [
                        'id' => $value->id(),
                        'name' => $value->last_name . ' ' . $value->first_name . ' ' . $value->other_name,
                        'recorded_subjects' => $value->playgroupResults->where('grade_id', $grade_id)->where('term_id', $term_id)->where('period_id', $period_id)->count(),
                        'publish_state' => publishExamState($value->id(), $period_id, $term_id),
                    ];
                }
            }
            
            return response()->json([
                'students' => $students,
                'grade' => $grade_id,
                'grade_name' => $grade->title(),
                'period' => $period_id,
                'term' => $term_id,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    
    public function singleCheckExam($student_id, $grade_id, $period_id, $term_id)
    {
        try {

            $grade = Grade::find($grade_id);
            $template = get_settings('result_template');
            $data = Student::where('uuid', $student_id)->first();

            if ($grade->title !== 'Playgroup'){
                $result = [
                        'id' => $data->id(),
                        'name' => $data->last_name . ' ' . $data->first_name . ' ' . $data->other_name,
                        'recorded_subjects' => $data->primaryResults->where('grade_id', $grade_id)->where('term_id', $term_id)->where('period_id', $period_id)->count(),
                ];
            }else{
                $result[] = [
                    'id' => $data->id(),
                    'name' => $data->last_name . ' ' . $data->first_name . ' ' . $data->other_name,
                    'recorded_subjects' => $data->playgroupResults->where('grade_id', $grade_id)->where('term_id', $term_id)->where('period_id', $period_id)->count(),
                ];
            }
            
            return response()->json([
                'result' => $result,
                'grade' => $grade_id,
                'grade_name' => $grade->title(),
                'period' => $period_id,
                'term' => $term_id,
                'current_class' => $data->grade->title()
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function studentComment($student_id, $period_id, $term_id)
    {
        try {
            $data = Cognitive::where([
                'student_uuid' => $student_id,
                'term_id' => $term_id,
                'period_id' => $period_id
            ])->first();

            if ($data) {
                $comment = [
                    'id' => $data->id(),
                    'total' => $data->attendance_duration,
                    'present' => $data->attendance_present,
                    'comment' => $data->comment,
                ];
        
                return response()->json([
                    'status' => 1,
                    'comment' => $comment,
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    
     public function generateMidtermResult(Request $request)
    {
        try{

            $grade = $request->grade_id;
            $period = $request->period_id;
            $term = $request->term_id;
            $students = Student::where('grade_id', $grade)->get();
        
            DB::transaction(function () use ($students, $period, $term, $grade) {
                $midtermFormat = get_settings('midterm_format');
        
                foreach ($students as $student) {
                    $examResults = PrimaryResult::where([
                        'grade_id' => $grade,
                        'period_id' => $period,
                        'term_id' => $term,
                        'student_id' => $student->id()
                    ])->get();
        
                    if ($examResults->isNotEmpty()) {
                        foreach ($examResults as $result) {
                            if ($result->student_id === $student->id()) {
                                $subjectId = $result->subject_id;

                                $check = MidTerm::where([
                                    'grade_id' => $grade,
                                    'period_id' => $period,
                                    'term_id' => $term,
                                    'student_id' => $student->id(),
                                    'subject_id' => $subjectId,
                                ])->first();
        
                                if($check){
                                    continue;
                                }else{
                                    $newMidtermResult = new MidTerm([
                                        'grade_id' => $grade,
                                        'period_id' => $period,
                                        'term_id' => $term,
                                        'subject_id' => $subjectId,
                                        'student_id' => $student->id(),
                                        'author_id' => auth()->id(),
                                        'entry_1' => $result->ca1 / 2,
                                        'entry_2' => $result->ca1 / 2,
                                        'first_test' => $result->ca3,
                                        'ca' => $result->ca2,
                                        'project' => $result->pr,
                                    ]);
                
                                    // foreach ($midtermFormat as $key => $value) {
                                    //     if (isset($result->$key)) {
                                    //         $newMidtermResult[$key] = $result->$key;
                                    //     }
                                    // }
        
                                    $newMidtermResult->save();
                                }
                                
                            }
                        }
                    }

                    continue;
                }
            });
        
            return response()->json([
                'status' => true,
                'message' => 'Result generated successfully!',
            ], 200);
        }catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    
    public function generateSingleMidtermPDF(Request $request)
    {
        try {
            $period = Period::where('id', $request->period_id)->first();
            $term = Term::where('id', $request->term_id)->first();
            $student = Student::findOrfail($request->student_id);
            $result = $student->midTermResults->where('period_id', $request->period_id)
            ->where('term_id',  $request->term_id)
            ->where('grade_id',  $request->grade_id)->all();


            usort($result, function ($a, $b) {
                $mathematicsEnglish = ['Mathematics', 'English Language'];
        
                if (in_array($a->subject->title(), $mathematicsEnglish) && !in_array($b->subject->title(), $mathematicsEnglish)) {
                    return -1;
                } elseif (!in_array($a->subject->title(), $mathematicsEnglish) && in_array($b->subject->title(), $mathematicsEnglish)) {
                    return 1;
                } else {
                    return strcasecmp($a->subject->title(), $b->subject->title());
                }
            });

            $scores = [];

            foreach ($result as $item) {
                $total_score = $item->entry_1 + $item->entry_2 + $item->first_test + $item->ca + $item->class_activity + $item->project;
                $subject_id = $item->subject_id;
                $scores[$subject_id] = $total_score;
            }
            
            $weakness_info = "Dear $student->first_name, based on your current term score, you need to improve in the following subject(s):";
            $commentResult = generate_comment($scores, $weakness_info, 0.5, 60);

            $filename = "{$student->id()}_result.pdf";

            $pdf = PDF::loadView('admin.result.primary_midterm_pdf_result', [
                'results' => $result,
                'student' => $student,
                'scores' => $scores,
                'comment' => $commentResult,
                'period' => $period,
                'term' => $term
            ]);

            return $pdf->download($filename);

        } catch (\Throwable $th) {
            $notification = ([
                'messege' => $th->getMessage(),
                'alert-type' => 'error',
                'button' => 'Okay',
                'title' => 'Error generating result'
            ]);
            return redirect()->back()->with($notification);
        }
    }
    
    public function generateSingleExamPDF(Request $request)
    {
        try {
            $period = Period::where('id', $request->period_id)->first();
            $term = Term::where('id', $request->term_id)->first();
            $student = Student::where('uuid', $request->student_id)->first();
            $result = $student->primaryResults->where('period_id', $request->period_id)
            ->where('term_id',  $request->term_id)
            ->where('grade_id',  $request->grade_id);
            
            $grade = Grade::find($request->grade_id);

            if($request->term_id == 1){
                $know = (int) $request->term_id +1;
            }elseif($request->term_id == 1){
                $know = (int) $request->term_id +1;
            }else{
                $know = 1;
            }
            
            $psychomotors = $student->psychomotors->where('period_id', $request->period_id)
            ->where('term_id', $request->term_id);

            $affectives = $student->affectives->where('period_id', $request->period_id)
            ->where('term_id', $request->term_id);

            $studentAttendance = Cognitive::where('period_id', $request->period_id)
                                            ->where('term_id', $request->term_id)
                                            ->where('student_uuid', $student->id())->first();

            $first_term = 1;
            $second_term = 2;
            
            $first_term_cumm = Cummulative::where('term_id', $first_term)->where('student_uuid', $student->id())->where('period_id', $request->period_id)->get();
            $second_term_cumm = Cummulative::where('term_id', $second_term)->where('student_uuid', $student->id())->where('period_id', $request->period_id)->get();
            $studentResults = $student->primaryResults->where('term_id', $term->id())->where('period_id', $period->id);
            $midtermFormat = get_settings('midterm_format');
            $examFormat = get_settings('exam_format');

            $newFirst = array();
            foreach ($first_term_cumm as $key => $value) {
                $newFirst[] = [
                    'first_term_cummulative' => $value->score,
                    'subject_id' => $value->subject_id,
                    'grade_id' => $value->grade_id,
                    'term_id' => $value->term_id,
                    'period_id' => $value->period_id,
                ];
            }

            $newSecond = array();
            foreach ($second_term_cumm as $key => $value) {
                $newSecond[] = [
                    'second_term_cummulative' => $value->score,
                    'subject_id' => $value->subject_id,
                    'grade_id' => $value->grade_id,
                    'term_id' => $value->term_id,
                    'period_id' => $value->period_id,
                ];
            }

            $newResult = array();
            foreach ($studentResults as $key => $value) {
                $result = array();
                $result['total'] = $value->ca1 + $value->ca2 + $value->ca3 + $value->pr + $value->exam;
                $result['subject_id'] = $value->subject->id();
                $result['subject'] = $value->subject->title();
                $result['ca1'] = $value->ca1;
                $result['ca2'] = $value->ca2;
                $result['ca3'] = $value->ca3;
                $result['pr'] = $value->pr;
                $result['exam'] = $value->exam;
                $newResult[] = $result;
            }    
            
            $firstTermResult = $newResult;
            $secondTermResult = $this->custom_array_merge($newFirst, $newResult);
            $thirdTermResult = $this->custom_array_merge($secondTermResult, $newSecond);

            if($request->term_id === '1'){
                $results = $newResult;
            }elseif ($request->term_id === '2') {
                $results = $this->custom_array_merge($newFirst, $newResult);
            }elseif($request->term_id === '3'){
                $results = $this->custom_array_merge($secondTermResult, $newSecond);
            }

            $scores = [];

            foreach ($results as $item) {
                $total_score = $item['total'];
                $subject_id = $item['subject_id'];
                $scores[$subject_id] = $total_score;
            }

            $weakness_info = "Dear $student->first_name $student->last_name, you need to work harder next term, ";
            $comment = generate_comment($scores, $weakness_info, 0.56, 100, 'examination');

            $totalDays = 0;
            $weeks = Week::where('term_id', $request->term_id)->where('period_id', $request->period_id)->get();
            foreach ($weeks as $item) {
                $startDate = new \DateTime($item['start_date']);
                $endDate = new \DateTime($item['end_date']);
                $interval = new \DateInterval('P1D'); // 1 day interval

                $duration = new \DatePeriod($startDate, $interval, $endDate);

                foreach ($duration as $date) {
                    if ($date->format('N') <= 5) {
                        $totalDays++;
                    }
                }
            }

            $marksObtained = 0;
            $numSubjects = count($results);
            $grand = $numSubjects * 100;
            
            usort($results, function ($a, $b) {
                $mathematicsEnglish = ['Mathematics', 'English Language'];
        
                if (in_array($a['subject'], $mathematicsEnglish) && !in_array($b['subject'], $mathematicsEnglish)) {
                    return -1;
                } elseif (!in_array($a['subject'], $mathematicsEnglish) && in_array($b['subject'], $mathematicsEnglish)) {
                    return 1;
                } else {
                    return strcasecmp($a['subject'], $b['subject']);
                }
            });

            foreach($results as $result){
                $total = $result['total'];
                $marksObtained += $total;
            }
            
            $aggregate = $marksObtained / $numSubjects;
            $position = calculateStudentPosition($student->id(), new PrimaryResult(), $period->id(), $term->id(), $student->grade->id());
            $filename = "{$student->last_name}_{$student->first_name}_{$student->other_name}_result.pdf";
            $termSetting = termSetting($request->term_id, $request->period_id);

            $pdf = PDF::loadView('admin.result.exam_pdf_result', [
                'period' => $period,
                'term' => $term,
                'marksObtained' => $marksObtained,
                'aggregate' => $aggregate,
                'position' => $position,
                'comment' => $comment,
                'studentAttendance' => $studentAttendance,
                'student' => $student,
                'psychomotors' => $psychomotors,
                'affectives' => $affectives,
                'totalSchoolOpen' => $totalDays,
                'first_term_cumm' => $first_term_cumm,
                'second_term_cumm' => $second_term_cumm,
                'results' => $results,
                'grade'  => $grade,
                'termSetting' => $termSetting
            ]);

            return $pdf->download($filename);
        } catch (\Throwable $th) {
            $notification = ([
                'messege' => $th->getMessage(),
                'alert-type' => 'error',
                'button' => 'Okay',
                'title' => 'Error generating result'
            ]);
            return redirect()->back()->with($notification);
        }
        
    }
    
    public function exportExcel(Request $request)
    {
        return Excel::download(new MidtermResultDataExport($request), 'midterm_result_.xlsx');
    }
    
    public function studentSubject($student_id)
    {
        try {
            $student = Student::whereUuid($student_id)->first();
            $subjects = [];
            foreach($student->subjects as $subject) {
                $subjects[] = [
                    'id' => $subject->id(),
                    'name' => $subject->title()
                ];
            }
            return response()->json($subjects);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    
    public function gradeResultStatistic($grade_id, $period_id)
    {
        try {
            $studentsResults = PrimaryResult::where('primary_results.grade_id', $grade_id)
                ->where('primary_results.period_id', $period_id)
                ->join('students', 'primary_results.student_id', '=', 'students.uuid')
                ->orderBy('students.last_name', 'asc')
                ->with('student') 
                ->get();

            $students = [];
            $studentTotalScores = [];

            foreach ($studentsResults as $result) {

                if (!$result->student) {
                    continue;
                }

                $student = $result->student;
                $studentId = $student->uuid;

                if (!isset($students[$studentId])) {
                    $students[$studentId] = [
                        'student_id' => $student->id(),
                        'student_name' => $student->last_name . ' ' . $student->first_name . ' ' . $student->other_name,
                        'first_term_total' => 0,
                        'second_term_total' => 0,
                        'third_term_total' => 0,
                        'total' => 0,
                    ];
                }

                $totalScore = $result->ca1 + $result->ca2 + $result->ca3 + $result->pr + $result->exam;

                if ($result->term_id == 1) {
                    $students[$studentId]['first_term_total'] += $totalScore;
                } elseif ($result->term_id == 2) {
                    $students[$studentId]['second_term_total'] += $totalScore;
                } elseif ($result->term_id == 3) {
                    $students[$studentId]['third_term_total'] += $totalScore;
                }

                $students[$studentId]['total'] += $totalScore;
                $studentTotalScores[$studentId] = $students[$studentId]['total'];
            }

            foreach ($students as &$studentData) {
                $studentId = $studentData['student_id'];
                $positionWithSuffix = calculateAdminGradePosition($studentTotalScores, $studentId);
                $studentData['position'] = $positionWithSuffix;
            }

            usort($students, function ($a, $b) {
                $positionA = (int) substr($a['position'], 0, -2);
                $positionB = (int) substr($b['position'], 0, -2);
                return $positionA - $positionB;
            });

            return response()->json([
                'status' => true,
                'students' => array_values($students),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function getHighestScoreBySubject($grade_id, $period_id, $subject_id)
    {
        try {
            $studentsResults = PrimaryResult::where('primary_results.grade_id', $grade_id) 
                ->where('primary_results.period_id', $period_id)
                ->where('primary_results.subject_id', $subject_id)
                ->join('students', 'primary_results.student_id', '=', 'students.uuid')
                ->orderBy('students.last_name', 'asc')
                ->with('student') // Make sure 'student' is eager loaded
                ->get();
    
            $students = [];
            $studentTotalScores = [];
    
            foreach ($studentsResults as $result) {
                // Check if the student relation is not null
                if (!$result->student) {
                    // Skip the result if no student data is found
                    continue;
                }
    
                $student = $result->student;
                $studentId = $student->uuid;
    
                // Initialize the student data if not already initialized
                if (!isset($students[$studentId])) {
                    $students[$studentId] = [
                        'student_id' => $student->uuid,
                        'student_name' => $student->last_name . ' ' . $student->first_name . ' ' . $student->other_name,
                        'first_term_total' => 0,
                        'second_term_total' => 0,
                        'third_term_total' => 0,
                        'total' => 0,
                    ];
                }
    
                // Calculate the total subject score for the current term
                $subjectScore = $result->ca1 + $result->ca2 + $result->ca3 + $result->pr + $result->exam;
    
                // Assign scores for each term
                if ($result->term_id == 1) {
                    $students[$studentId]['first_term_total'] += $subjectScore;
                } elseif ($result->term_id == 2) {
                    $students[$studentId]['second_term_total'] += $subjectScore;
                } elseif ($result->term_id == 3) {
                    $students[$studentId]['third_term_total'] += $subjectScore;
                }
    
                // Update the total score
                $students[$studentId]['total'] += $subjectScore;
    
                // Store the total score for ranking purposes
                $studentTotalScores[$studentId] = $students[$studentId]['total'];
            }
    
            // Calculate the positions of each student based on total scores
            foreach ($students as &$studentData) {
                $studentId = $studentData['student_id'];
                $positionWithSuffix = calculateAdminGradePosition($studentTotalScores, $studentId);
                $studentData['position'] = $positionWithSuffix;
            }
    
            // Sort students by position
            usort($students, function ($a, $b) {
                $positionA = (int) substr($a['position'], 0, -2);
                $positionB = (int) substr($b['position'], 0, -2);
                return $positionA - $positionB;
            });
    
            return response()->json([
                'status' => true,
                'students' => array_values($students), // Convert associative array to indexed array
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    
    public function storePlayGroupResult(Request $request)
    {
        try {
            DB::transaction(function () use ($request){
                $subjectIds = $request->input('subject_id');
                $remarks = $request->input('remark');

                $student = Student::find($request->student_id);

                foreach ($subjectIds as $subjectId) {
                    $remark = $remarks[$subjectId];
                    $result = new PlaygroupResult([
                        'term_id' => $request->term_id,
                        'period_id' => $request->period_id,
                        'student_id' => $student->id(),
                        'grade_id' => $student->grade_id,
                        'subject_id' => $subjectId,
                        'author_id' => auth()->id()
                    ]);

                    $check = PlaygroupResult::where([
                        'student_id' => $student->id(),
                        'subject_id' => $subjectId,
                        'term_id' => $request->term_id,
                        'period_id' => $request->period_id
                    ])->first();
                    
                    if (strpos($remark, ':') !== false && strpos($remark, '.') !== false) {
                        $remarkParts = explode('.', $remark);
                        $remarkArray = [];
            
                        foreach ($remarkParts as $part) {
                            $parts = explode(':', $part);
                            if (count($parts) === 2) {
                                $key = trim($parts[0]);
                                $value = trim($parts[1]);
                                $remarkArray[$key] = $value;
                            }
                        }

                        if($check){
                            $check->update([
                                'remark' => $remarkArray
                            ]);
                        }else{
                            $result['remark'] = $remarkArray;
                            $result->save();
                        }

                    } else {
                        if($check){
                            $check->update([
                                'remark' => $remark
                            ]);
                        }else{
                            $result['remark'] = $remark;
                            $result->save();
                        }
                    }

                }
            });

            return response()->json([
                'status' => true,
                'message' => 'Result submitted successfully!'
            ], 200);
        } catch (\Throwable $th) {
           return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
           ], 500);
        }
    }

    public function showPlaygroupResult($student_id, $period_id, $term_id)
    {
        try {
            $data = PlaygroupResult::where([
                'student_id' => $student_id,
                'term_id' => $term_id,
                'period_id' => $period_id
            ])->get();

            if ($data) {
                $result = [];
                foreach($data as $key => $value) {
                    $subject = Subject::findOrFail($value->subject_id);

                    $result[] = [
                        'id' => $value->id(),
                        'subject_name' => $subject->title(),
                        'subject_id' => $value->subject_id,
                        'term_id' => $value->term_id,
                        'period_id' => $value->period_id,
                        'remark' => $value->remark,
                    ];
                }
        
                return response()->json([
                    'status' => true,
                    'results' => $result,
                    'student_id' => $student_id,
                    'period_id' => $period_id,
                    'term_id' => $term_id
                ], 200);
            }
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function playgroupShow(Student $student, Request $request)
    {
        $period = Period::where('id', $request->period_id)->first();
        $term = Term::where('id', $request->term_id)->first();

        $results = PlayGroupResult::where([
            'student_id' => $student->id(),
            'period_id' => $period->id(),
            'term_id' => $term->id()
        ])->get();

        $studentAttendance = Cognitive::where('period_id', $request->period_id)
                                        ->where('term_id', $request->term_id)
                                        ->where('student_uuid', $student->id())->first();
        
        $psychomotors = $student->affectives->where('period_id', $request->period_id)->where('term_id', $request->term_id);

        return view('admin.result.playgroup',[
            'student' => $student,
            'period' => $period,
            'term' => $term,
            'results' => $results,
            'studentAttendance' => $studentAttendance,
            'psychomotors' => $psychomotors,
        ]);
    }

    public function generateSinglePlaygroupPDF(Request $request)
    {
        $period = Period::where('id', $request->period_id)->first();
        $term = Term::where('id', $request->term_id)->first();
        $student = Student::findOrfail($request->student_id);
        
        $results = PlayGroupResult::where([
            'student_id' => $student->id(),
            'period_id' => $period->id(),
            'term_id' => $term->id()
        ])->get();

        $studentAttendance = Cognitive::where('period_id', $request->period_id)
                                        ->where('term_id', $request->term_id)
                                        ->where('student_uuid', $student->id())->first();
        
        $psychomotors = $student->affectives->where('period_id', $request->period_id)->where('term_id', $request->term_id);

        $filename = "{$student->last_name}_{$student->first_name}_{$student->other_name}_result.pdf";

        $pdf = PDF::loadView('admin.result.playgroup.playgroup_pdf_result', [
            'period' => $period,
            'term' => $term,
            'studentAttendance' => $studentAttendance,
            'student' => $student,
            'psychomotors' => $psychomotors,
            'results' => $results,
        ]);

        return $pdf->download($filename);
    }
    
    public function downloadSubjectStatistic(Request $request)
    {
        try {
            $grade_id = $request->get('grade_id');  
            $period_id = $request->get('period_id');  
            $subject_id = $request->get('subject_id');  

            $grade = Grade::findOrFail($grade_id);
            $subject = Subject::findOrFail($subject_id);
            
            $studentsData = Student::whereHas('grade', function($query) use ($grade){
                $query->where('title', 'like', get_grade($grade->title()) .'%');
            })->orderBy('last_name', 'asc')->get();
            
            $students = [];

            foreach ($studentsData as $student) {
                $studentData = [
                    'student_id' => $student->id(),
                    'student_name' => $student->last_name . ' '. $student->first_name . ' '. $student->other_name,
                    'first_term_total' => 0,
                    'second_term_total' => 0,
                    'third_term_total' => 0,
                    'total' => 0,
                ];

                for ($term_id = 1; $term_id <= 3; $term_id++) {
                    $subjectScore = 0;

                    $examSubjectResult = $student->primaryResults->where('period_id', $period_id)
                    ->where('subject_id', $subject_id)->where('term_id',  $term_id)->first();

                    if ($examSubjectResult) {
                        $subjectScore += $examSubjectResult->ca1 + $examSubjectResult->ca2 + $examSubjectResult->ca3 + $examSubjectResult->pr + $examSubjectResult->exam;
                    }

                    if ($term_id == 1) {
                        $studentData['first_term_total'] = $subjectScore;
                    } elseif ($term_id == 2) {
                        $studentData['second_term_total'] = $subjectScore;
                    } elseif ($term_id == 3) {
                        $studentData['third_term_total'] = $subjectScore;
                    }

                    $studentData['total'] += $subjectScore;
                    $studentTotalScores[$student->id()] = $studentData['total'];
                }

                $students[] = $studentData;
            }

            foreach ($students as &$studentData) {
                $studentId = $studentData['student_id'];
                $positionWithSuffix = calculateAdminGradePosition($studentTotalScores, $studentId);
                $studentData['position'] = $positionWithSuffix;
            }

            usort($students, function ($a, $b) {
                $positionA = (int)substr($a['position'], 0, -2);
                $positionB = (int)substr($b['position'], 0, -2);
                return $positionA - $positionB;
            });

            
            $filename = "result_statistic.pdf";

            $pdf = PDF::loadView('admin.result.subject_statistic', [
                'students' => $students,
                'subject' => $subject
            ]);

            return $pdf->download($filename);

            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function downloadGradeStatistic(Request $request)
    {
        try {
            
            $grade_id = $request->get('grade_id');
            $period_id = $request->get('period_id');
            
            $grade = Grade::findOrFail($grade_id);
            $studentsData = Student::whereHas('grade', function($query) use ($grade){
                $query->where('title', 'like', get_grade($grade->title()) .'%');
            })->orderBy('last_name', 'asc')->get();
            
            $students = [];

            foreach ($studentsData as $student) {
                $studentData = [
                    'student_id' => $student->id(),
                    'student_name' => $student->last_name . ' '. $student->first_name . ' '. $student->other_name,
                    'first_term_total' => 0,
                    'second_term_total' => 0,
                    'third_term_total' => 0,
                    'total' => 0,
                ];
        
                for ($term_id = 1; $term_id <= 3; $term_id++) {
                    $examResults = $student->primaryResults->where('period_id', $period_id)
                        ->where('term_id',  $term_id);
        
                    $examTotalScores = $examResults->map(function ($result) {
                        return $result->ca1 + $result->ca2 + $result->ca3 + $result->pr + $result->exam;
                    });

                    $totalScores = $examTotalScores->sum();

        
                    if ($term_id == 1) {
                        $studentData['first_term_total'] = $totalScores;
                    } elseif ($term_id == 2) {
                        $studentData['second_term_total'] = $totalScores;
                    } elseif ($term_id == 3) {
                        $studentData['third_term_total'] = $totalScores;
                    }
        
                    $studentData['total'] += $totalScores;
                    $studentTotalScores[$student->id()] = $studentData['total'];
                }
        
                $students[] = $studentData;
            }

            foreach ($students as &$studentData) {
                $studentId = $studentData['student_id'];
                $positionWithSuffix = calculateAdminGradePosition($studentTotalScores, $studentId);
                $studentData['position'] = $positionWithSuffix;
            }

            usort($students, function ($a, $b) {
                $positionA = (int)substr($a['position'], 0, -2);
                $positionB = (int)substr($b['position'], 0, -2);
                return $positionA - $positionB;
            });
            
            $filename = "result_grade_statistic.pdf";

            $pdf = PDF::loadView('admin.result.grade_statistic', [
                'students' => $students,
            ]);

            return $pdf->download($filename);

            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    
    public function studentHeadmistressComment($student_id, $period_id, $term_id)
    {
        try {
            $data = Cognitive::where([
                'student_uuid' => $student_id,
                'term_id' => $term_id,
                'period_id' => $period_id
            ])->first();

            if($data){
                $comment = [
                    'id' => $data->id(),
                    'headmistress_comment' => $data->headmistress_comment,
                    'promotion_comment' => $data->promotion_comment,
                ];
            }else{
                $comment = [];
            }


            return response()->json([
                'status' => 1,
                'comment' => $comment,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function headmistressComment(Request $request)
    {
        
            $check = Cognitive::where('student_uuid', $request->student_uuid)
            ->where('period_id', $request->period_id)
            ->where('term_id', $request->term_id)->first();
            

            try {
                if($check){
                    $check->update([
                        'headmistress_comment' => $request->has('headmistress_comment') ? $request->headmistress_comment : $check->headmistress_comment,
                        'promotion_comment' => $request->has('promotion_comment') ? $request->promotion_comment : $check->promotion_comment,
                    ]);
                }else{
                    $cognitive = new Cognitive([
                        'headmistress_comment' => $request->headmistress_comment,
                        'promotion_comment' => $request->promotion_comment,
                        'period_id'     => $request->period_id,
                        'term_id'       => $request->term_id,
                        'student_uuid'        => $request->student_uuid,
                    ]);
                    $cognitive->save();
                }
                return response()->json(['status' => true, 'message' => 'Comment saved successfully'], 200);
            } catch (\Exception $th) {
                DB::rollback();
                return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
            }
         
    }
    
    
}