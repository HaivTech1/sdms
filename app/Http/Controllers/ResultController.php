<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\Event;
use App\Models\Period;
use App\Models\Result;
use App\Models\Student;
use App\Models\Cognitive;
use App\Jobs\CreateResult;
use App\Models\Cummulative;
use App\Models\psychomotor;
use Illuminate\Http\Request;
use App\Policies\ResultPolicy;
use App\Jobs\CreateSingleResult;
use App\Http\Requests\StoreResultRequest;
use App\Http\Requests\SingleResultRequest;
use App\Http\Requests\UpdateResultRequest;

class ResultController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('admin.result.index',[
            'user' => $user,
            'periods' => Period::all()->pluck('title', 'id'),
            'terms' => Term::all()->pluck('title', 'id')
        ]);
    }

    public function create()
    {
        return view('admin.result.create');
    }

    public function store(StoreResultRequest $request)
    {
        // dd($request);
        $this->dispatchSync(CreateResult::fromRequest($request));

        $notification = array (
            'messege' => 'Result uploaded successfully',
            'alert-type' => 'success',
            'button' => 'Okay!',
            'title' => 'Success'
        );

        return redirect()->back()->with($notification);
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
        $date = Event::where('period_id', $request->period_id)
        ->where('term_id', $request->term_id)->where('category', 'bg-success')->get();

        $last_date = count($date) > 0 ? $date[0]->start : date('d-m-y H:i:s');
        $current_date = count($date) > 0 ? $date[0]->end : date('d-m-y H:i:s');
    
         //NUMBER DAYS BETWEEN TWO DATES CALCULATOR
        $start_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $last_date);
        $end_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $current_date);
        $termDuration = $start_date->diffInDays($end_date);

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

        $cognitives = $student->cognitives->where('period_id', $request->period_id)
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

        // dd($results);
       
        return view('admin.result.show',[
            'student' => $student,
            'period' => $period,
            'term' => $term,
            'totalExamScrore' => $totalExamScrore,
            'totalSubject' => $totalSubject,
            'average' => $average,
            'psychomotors' => $psychomotors,
            'cognitives' => $cognitives,
            'attendance' => $attendance,
            'termDuration' => $termDuration,
            'studentAttendanceAve' => $studentAttendanceAve,
            'endOfTerm' => count($date) > 0 ? $current_date->format('d-m-Y') : date('d-m-y'),
            'endOfNextTerm' => count($date) > 0 ? $nextTerm->start->format('d-m-Y') : date('d-m-y'),
            'first_term_cumm' => $first_term_cumm,
            'second_term_cumm' => $second_term_cumm,
            'results' => $results
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

    public function singleUpload()
    {
        return view('admin.result.singleUpload');
    }

    public function storeSingleUpload(SingleResultRequest $request)
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

    public function check()
    {
        return view('admin.result.check');
    }

    public function update(UpdateResultRequest $request, Result $result)
    {
        //
    }

    public function destroy(Result $result)
    {
        //
    }

    public function psychomotor(Request $request)
    {
        $check = psychomotor::where('student_uuid', $request->student_uuid)
            ->where('period_id', $request->period_id)
            ->where('term_id', $request->term_id)->get();

            return response()->json(['status' => 'success', 'data' => $check]); 
    }

    public function psychomotorUpload(Request $request)
    {

        $check = psychomotor::where('student_uuid', $request->student_uuid)
            ->where('period_id', $request->period_id)
            ->where('term_id', $request->term_id)->get();


            if (count($check) > 1) {
                return response()->json(['status' => 'error', 'message' => 'Psychomotor already exist']); 
                // $notification = array (
                //     'messege' => 'Psychomotor already exist',
                //     'alert-type' => 'error',
                //     'button' => 'Okay!',
                //     'title' => 'Failed'
                // );
        
                // return redirect()->back()->with($notification);
            }else{
                for ($i = 0; $i < count($request->title); $i++) { 
                    $psychomotor = new psychomotor([
                        'title' => $request->title[$i],
                        'rate' => $request->rate[$i],
                        'period_id'     => $request->period_id,
                        'term_id'       => $request->term_id,
                        'student_uuid'        => $request->student_uuid,
                    ]);
                    $psychomotor->save();
                }
                // $notification = array (
                //     'messege' => 'Psychomotor saved successfully',
                //     'alert-type' => 'success',
                //     'button' => 'Okay!',
                //     'title' => 'Success'
                // );
        
                // return redirect()->back()->with($notification);
                return response()->json(['status' => 'success', 'message' => 'Psychomotor saved successfully']);
            }
         
    }

    public function cognitive(Request $request)
    {
        $check = Cognitive::where('student_uuid', $request->student_uuid)
            ->where('period_id', $request->period_id)
            ->where('term_id', $request->term_id)->get();

            return response()->json(['status' => 'success', 'data' => $check]); 
    }

    public function cognitiveUpload(Request $request)
    {

        $check = Cognitive::where('student_uuid', $request->student_uuid)
            ->where('period_id', $request->period_id)
            ->where('term_id', $request->term_id)->get();


            if (count($check) > 1) {
                // $notification = array (
                //     'messege' => 'Cognitive already exist',
                //     'alert-type' => 'error',
                //     'button' => 'Okay!',
                //     'title' => 'Failed'
                // );
        
                // return redirect()->back()->with($notification);
                return response()->json(['status' => 'error', 'message' => 'Cognitive already exist']); 
            }else{
                for ($i = 0; $i < count($request->title); $i++) { 
                    $psychomotor = new Cognitive([
                        'title' => $request->title[$i],
                        'rate' => $request->rate[$i],
                        'period_id'     => $request->period_id,
                        'term_id'       => $request->term_id,
                        'student_uuid'        => $request->student_uuid,
                    ]);
                    $psychomotor->save();
                }
                // $notification = array (
                //     'messege' => 'Cognitive saved successfully',
                //     'alert-type' => 'success',
                //     'button' => 'Okay!',
                //     'title' => 'Success'
                // );
        
                // return redirect()->back()->with($notification);
                return response()->json(['status' => 'success', 'message' => 'Cognitive saved successfully']);
            }
         
    }

    public function publish(Request $request)
    {
        $results = Result::where('student_id', $request->student_id)->where('term_id', $request->term_id)->where('period_id', $request->period_id)->where('grade_id', $request->grade_id)->get();
        
        $cum = array();

        foreach($results as $result){
            // $events[] = [
            //     'subject_id' => $result['subject_id'],
            //     'score' =>  $result['ca1'] + $result['ca2'] + $result['ca3'] + $result['exam'],
            //     'student_uuid' => $request->student_id,
            //     'term_id' => $request->term_id,
            //     'period_id' => $request->period_id,
            //     'grade_id' => $request->grade_id,
            // ];
            $cummulative = new Cummulative([
                'subject_id' => $result['subject_id'],
                'score' => $result['ca1'] + $result['ca2'] + $result['ca3'] + $result['exam'], 
                'student_uuid' => $result['student_id'], 
                'period_id' => $result['period_id'],
                'term_id' => $result['term_id'], 
                'grade_id' => $result['grade_id'], 
                'author_id' => auth()->id()
            ]);
            $cummulative->save();
        }

        return response()->json(['status' => 'success','message' => 'Result cummulated successfully!' ], 200);
    }

    public function cummulative(Request $request)
    {
        $check = Cummulative::where('student_uuid', $request->student_uuid)
            ->where('period_id', $request->period_id)
            ->where('term_id', $request->term_id)->get();

            return response()->json(['status' => 'success', 'data' => $check]); 
    }
}