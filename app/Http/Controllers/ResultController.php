<?php

namespace App\Http\Controllers;

use PDF;
use Excel;
use App\Models\Term;
use App\Models\Week;
use App\Models\Event;
use App\Models\Period;
use App\Models\Result;
use App\Models\MidTerm;
use App\Models\Pincode;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Affective;
use App\Models\Cognitive;
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
use App\Traits\NotifiableParentsTrait;
use App\Http\Requests\StoreResultRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SingleResultRequest;
use App\Http\Requests\UpdateResultRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        if($request->term_id == 1){
            $know = (int) $request->term_id +1;
        }elseif($request->term_id == 1){
            $know = (int) $request->term_id +1;
        }else{
            $know = 1;
        }

        // $result = $student->primaryResults->where('period_id', $request->period_id)
        //                             ->where('term_id', $request->term_id)
        //                             ->where('grade_id', $request->grade_id)
        //                             ->where('student_id', $student->id());

        // $totalExamScrore = $result->eTotal();
        // $totalSubject = $student->subjects->count();
        // $average = $totalExamScrore / $totalSubject;
        
                                    
        $period = Period::where('id', $request->period_id)->first();
        $term = Term::where('id', $request->term_id)->first();

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

            $result = [];
            $sum = 0;
            if (is_array($midtermFormat)) {
                foreach ($midtermFormat as $midtermKey => $midtermValue) {
                    if (isset($value->$midtermKey)) {
                        $result[$midtermKey] = $value->$midtermKey;
                        $sum += $value->$midtermKey;
                    }
                }
            }
        
            if (is_array($examFormat)) {
                foreach ($examFormat as $examKey => $examValue) {
                    if (isset($value->$examKey)) {
                        $result[$examKey] = $value->$examKey;
                    }
                }
            }
        
            unset($result['subject_id']);
            $result['total'] = array_sum($result);
            $result['midterm_total'] = $sum;
            $result['subject_id']= $value->subject->id();
            $result['subject'] = $value->subject->title();
            $newResult[] = $result;

            // dd($newResult);
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

        $scores = [];

        foreach ($results as $item) {
            $total_score = $item['total'];
            $subject_id = $item['subject_id'];
            $scores[$subject_id] = $total_score;
        }

        $weakness_info = "Dear $student->first_name, you need to improve in the following subject(s):";
        $comment = generate_comment($scores, $weakness_info, 0.4, 100, 'examination');

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

        $position = calculateStudentPosition($student->id(), new PrimaryResult(), $period->id(), $term->id(), $student->grade->id());

        $format = get_settings('result_template');

        if ($format === 1) {
            return view('admin.result.secondary',[
                'student' => $student,
                'period' => $period,
                'term' => $term,
                'psychomotors' => $psychomotors,
                'affectives' => $affectives,
                'totalSchoolOpen' => $totalDays,
                'first_term_cumm' => $first_term_cumm,
                'second_term_cumm' => $second_term_cumm,
                'results' => $results,
                'comment' => $comment,
                'studentAttendance' => $studentAttendance,
                'position' => $position,
            ]);
        }else{
            return view('admin.result.primary',[
                'student' => $student,
                'period' => $period,
                'term' => $term,
                'psychomotors' => $psychomotors,
                'affectives' => $affectives,
                'totalSchoolOpen' => $totalDays,
                'first_term_cumm' => $first_term_cumm,
                'second_term_cumm' => $second_term_cumm,
                'results' => $results,
                'comment' => $comment,
                'studentAttendance' => $studentAttendance,
                'position' => $position,
            ]);
        }
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
        $weakness_info = "Dear $student->first_name, based on your current term score, you need to improve in the following subject(s):";
        $comment = generate_comment($scores, $weakness_info, 0.5, 40);

        return view('admin.result.midterm_show',[
            'student' => $student,
            'period' => $period,
            'term' => $term,
            'results' => $result,
            'comment' => $comment
        ]);
    }

    private function custom_array_merge($newResult, $newFirst) {
        $result = Array();
        foreach ($newResult as $key_1 => $value_1) {
            foreach ($newFirst as $key_1 => $value_2) {
                if($value_1['subject_id'] ==  $value_2['subject_id']) {
                    $result[] = array_merge($value_1,$value_2);
                }
            }
    
        }
        return $result;
    }

    public function storeMidTerm(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'period_id'          => ['required'],
            'term_id'              => ['required'],
            'grade_id'              => ['required'],
            'student_id'              => ['required'],
        ],[
            "period_id.required" => "Session is required",
            "term_id.required" => "Session is required",
            "grade_id.required" => "Please select a class",
            "student_id.required" => "Please select a student!",
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'success' => 'false',
                'message'  => $validator->message()->all(),
            ], 400);
        }else{
            try{
                $check = MidTerm::where('period_id', $request->period_id)
                    ->where('term_id', $request->term_id)
                    ->where('grade_id', $request->grade_id)
                    ->where('student_id', $request->student_id)
                    ->first();
            
                $midtermFormat = get_settings('midterm_format');
            
                foreach ($request->subject_id as $i => $subjectId) {
                    $midtermData = [
                        'period_id' => $request->period_id,
                        'term_id' => $request->term_id,
                        'grade_id' => $request->grade_id,
                        'student_id' => $request->student_id,
                        'subject_id' => $subjectId
                    ];
            
                    foreach (array_keys($midtermFormat) as $key) {
                        if (isset($request->$key[$i])) {
                            $midtermData[$key] = $request->$key[$i];
                        }
                    }
            
                    if ($check) {
                        return response()->json(['status' => false, 'message' => 'Result already exists! Please edit'], 500);
                    } else {
                        $midterm = new MidTerm($midtermData);
                        $midterm->authoredBy(auth()->user());
                        $midterm->save();
                    }
                }
                
                return response()->json(['status' => true, 'message' => 'Result uploaded successfully!'], 200);
            }catch(\Exception $e){
                return response()->json([
                    'status' => false,
                    'message' => 'Error creating result: ' . $e->getMessage(),
                ], 500);
            }
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
                'message'  => $validator->message()->all(),
            ], 400);
        }else{
            try{
                foreach ($request->student_id as $i => $studentId) {

                    $check = MidTerm::where('period_id', $request->period_id)->where('term_id', $request->term_id)->where('grade_id', $request->grade_id)->where('subject_id', $request->subject_id)->where('student_id', $studentId)->first();
                    
                    if ($check) {
                        $midtermData = [];
                        $midtermData[$request->format] = $request->{$request->format}[$i];
                        $check->update($midtermData);
                    }else {
                        $midtermFormat = get_settings('midterm_format');

                        foreach ($request->student_id as $i => $studentId) {
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
                            
                            $midterm = new MidTerm($midtermData);
                            $midterm->authoredBy(auth()->user());
                            $midterm->save();
                        }
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
                'message'  => $validator->message()->all(),
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

                            $midtermFormat = get_settings('midterm_format');
                            $examFormat = get_settings('exam_format');

                            $midterm_entry = $midterm->where('subject_id', $subject_id)->first();
                            $result = new PrimaryResult([
                                'period_id'     => $request->period_id,
                                'term_id'       => $request->term_id,
                                'grade_id'      => $request->grade_id,
                                'student_id'    => $request->student_id,
                                'subject_id'    => $subject_id,
                            ]);

                            if (is_array($midtermFormat)) {
                                foreach ($midtermFormat as $key => $value) {
                                    if (isset($midterm_entry->$key)) {
                                        $result->$key = $midterm_entry->$key;
                                    }
                                }
                            }
                            
                            if (is_array($examFormat) && isset($request->exam[$i])) {
                                foreach ($examFormat as $key => $value) {
                                    $result->$key = $request->exam[$i];
                                }
                            }
                        
                            $result->authoredBy(auth()->user());
                            $result->save();
                        }
                    }
                }
            });

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
                'message'  => $validator->message()->all(),
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
                            ]);

                            if (is_array($midtermFormat)) {
                                foreach ($midtermFormat as $key => $value) {
                                    if (isset($midterm->$key)) {
                                        $result->$key = $midterm->$key;
                                    }
                                }
                            }
                            
                            if (is_array($examFormat) && isset($request->exam[$i])) {
                                foreach ($examFormat as $key => $value) {
                                    $result->$key = $request->exam[$i];
                                }
                            }
                        
                            $result->authoredBy(auth()->user());
                            $result->save();
                        }else{
                            $examData = [];
                            if (is_array($midtermFormat)) {
                                foreach ($midtermFormat as $key => $value) {
                                    if (isset($midterm->$key)) {
                                        $examData[$key] = $midterm->$key;
                                    }
                                }
                            }
                            
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
                ];
                
                if (is_array($midtermFormat)) {
                    foreach ($midtermFormat as $key => $value) {
                        if (isset($midterm->$key)) {
                            $examData[$key] = $midterm->$key;
                        }
                    }
                }

                foreach (array_keys($examFormat) as $key) {
                    if (isset($request->{$key})) {
                        $examData[$format] = $request->{$key};
                    }
                }
                
                dd($examData);
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
                $message = "<p> $name's examination result is now available on his/her portal. Please visit the school's website on " . application('website') . " to access the result with these credentials: Id Number: ".$idNumber." and password: ".$password." or password1234</p>";
                $subject = 'Evaluation Report Sheet';
        
                foreach($results as $result){
                    $result->update(['published' => true]);
                }
                
                NotifiableParentsTrait::notifyParents($student, $message, $subject);
        
                $check = Cummulative::where('student_uuid', $request->student_id)->where('term_id', $request->term_id)->where('period_id', $request->period_id)->where('grade_id', $request->grade_id)->get();
        
                if(count($check) > 0){
                    foreach($check as $value){
                        $value->delete();
                    }

                    $cum = array();
                    foreach($results as $result){
                        $cummulative = new Cummulative([
                            'subject_id' => $result['subject_id'],
                            'score' => calculateResult($result), 
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
                            'score' => calculateResult($result), 
                            'student_uuid' => $result['student_id'], 
                            'period_id' => $result['period_id'],
                            'term_id' => $result['term_id'], 
                            'grade_id' => $result['grade_id'], 
                            'author_id' => auth()->id()
                        ]);
                        $cummulative->save();
                    }
            
                }
            });
            return response()->json(['status' => true ,'message' => 'Result Published successfully!' ], 200);
        } catch (\Exception $th) {
            return response()->json(['status' => false ,'message' => $th->getMessage() ], 200);
        }
    }

    public function midtermPublish(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $results = MidTerm::where('student_id', $request->student_id)->where('term_id', $request->term_id)->where('period_id', $request->period_id)->where('grade_id', $request->grade_id)->get();
                $student = Student::findOrfail($request->student_id);
                $idNumber = $student->user->code();
                $password = 'password123';
                $name = $student->last_name." ".$student->first_name. " ".$student->first_name;
                $message = "<p> $name's mid term result is now available on his/her portal. Please visit the school's website on " . application('website') . " to access the result with these credentials: Id Number: ".$idNumber." and password: ".$password." or password1234</p>";
                $subject = 'Mid-term result';
        
                foreach($results as $result){
                    $result->update(['published' => true]);
                }

                NotifiableParentsTrait::notifyParents($student, $message, $subject);
            });

            return response()->json(['status' => true, 'message' => 'Result made available successfully! And email sent to parent.' ], 200);

        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
       

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
                                        foreach ($midtermFormat as $key => $value) {
                                            if (isset($midtermResult->$key)) {
                                                $examResult->$key = $midtermResult->$key;
                                            }
                                        }
            
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

    public function generateMidtermPDF($grade_id, $period_id, $term_id)
    {
        $period = Period::where('id', $period_id)->first();
        $term = Term::where('id', $term_id)->first();
        $students = Student::where('grade_id', $grade_id)->get();
        $totalStudents = count($students);
        $completedStudents = 0;
        $downloadLinks = [];
        
        foreach ($students as $student) {
            $result = $student->midTermResults->where('period_id', $period_id)
                ->where('term_id', $term_id)
                ->where('grade_id', $grade_id);

            $scores = [];

            foreach ($student->midTermResults as $item) {
                $total_score = $item->first_test + $item->second_test;
                $subject_id = $item->subject_id;
                $scores[$subject_id] = $total_score;
            }

            $weakness_info = "Dear {$student->first_name}, based on your current term score, you need to improve in the following subject(s):";
            $comment = generate_comment($scores, $weakness_info, 0.5, 40);

            $filename = "{$student->id()}_result.pdf";
            $directory = public_path("results/{$term->title()}/{$student->grade->title()}");

            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $path = "{$directory}/{$filename}";

            $pdf = PDF::loadView('admin.result.combined_results', [
                'results' => $result,
                'student' => $student,
                'scores' => $scores,
                'comment' => $comment,
                'period' => $period,
                'term' => $term
            ]);

            $pdf->save($path);

            $downloadLink = url("$path");
            $downloadLinks[] = $downloadLink;

            $completedStudents++;

            $progress = ($completedStudents / $totalStudents) * 100;
            echo json_encode(['progress' => $progress]);
            ob_flush();
            flush();
        }

        return response()->json([
            'status' => true,
            'links' => $downloadLinks,
            'message' => "PDF files generated for each student's result.",
        ], 200);
    }

    public function generateSingleMidtermPDF(Request $request)
    {
        try {
            $period = Period::where('id', $request->period_id)->first();
            $term = Term::where('id', $request->term_id)->first();
            $student = Student::findOrfail($request->student_id);
            $result = $student->midTermResults->where('period_id', $request->period_id)
            ->where('term_id',  $request->term_id)
            ->where('grade_id',  $request->grade_id);

            $scores = [];
            foreach ($student->midTermResults as $item) {
                $total_score = $item->first_test + $item->second_test;
                $subject_id = $item->subject_id;
                $scores[$subject_id] = $total_score;
            }

            $weakness_info = "Dear {$student->first_name}, based on your current term score, you need to improve in the following subject(s):";
            $commentResult = generate_comment($scores, $weakness_info, 0.5, 40);

            $filename = "{$student->id()}_result.pdf";

            $pdf = PDF::loadView('admin.result.midterm_pdf_result', [
                'results' => $result,
                'student' => $student,
                'scores' => $scores,
                'comment' => $commentResult,
                'period' => $period,
                'term' => $term
            ]);

            return $pdf->download($filename);

        } catch (\Throwable $th) {
           return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
           ], 500); 
        }
        
    }

    public function generateSingleExamPDF(Request $request)
    {
        try {
            $period = Period::where('id', $request->period_id)->first();
            $term = Term::where('id', $request->term_id)->first();
            $student = Student::findOrfail($request->student_id);
            $result = $student->primaryResults->where('period_id', $request->period_id)
            ->where('term_id',  $request->term_id)
            ->where('grade_id',  $request->grade_id);

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

                $result = [];
                $sum = 0;
                if (is_array($midtermFormat)) {
                    foreach ($midtermFormat as $midtermKey => $midtermValue) {
                        if (isset($value->$midtermKey)) {
                            $result[$midtermKey] = $value->$midtermKey;
                            $sum += $value->$midtermKey;
                        }
                    }
                }
            
                if (is_array($examFormat)) {
                    foreach ($examFormat as $examKey => $examValue) {
                        if (isset($value->$examKey)) {
                            $result[$examKey] = $value->$examKey;
                        }
                    }
                }
            
                unset($result['subject_id']);
                $result['total'] = array_sum($result);
                $result['midterm_total'] = $sum;
                $result['subject_id']= $value->subject->id();
                $result['subject'] = $value->subject->title();
                $newResult[] = $result;

                // dd($newResult);
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

            $scores = [];

            foreach ($results as $item) {
                $total_score = $item['total'];
                $subject_id = $item['subject_id'];
                $scores[$subject_id] = $total_score;
            }

            $weakness_info = "Dear $student->first_name, you need to improve in the following subject(s):";
            $comment = generate_comment($scores, $weakness_info, 0.4, 100, 'examination');

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

            foreach($results as $result){
                $total = $result['total'];
                $marksObtained += $total;
            }
            $aggregate = $marksObtained / $numSubjects;

            $position = calculateStudentPosition($student->id(), new PrimaryResult(), $period->id(), $term->id(), $student->grade->id());
            $filename = "{$student->id()}_result.pdf";

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
            ]);

            return $pdf->download($filename);
        } catch (\Throwable $th) {
           return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
           ], 500); 
        }
        
    }
}