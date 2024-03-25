<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cummulative;
use App\Models\MidTerm;
use App\Models\PrimaryResult;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\NumberBroadcast;
use App\Traits\NotifiableParentsTrait;

class ResultController extends Controller
{
    public function multipleExamPublish(Request $request)
    {
        try {
            $ids = json_decode($request->studentsIds, true);
            $period = $request->period_id;
            $term = $request->term_id;
            $grade = $request->grade_id;
            
            foreach($ids as $student_id){
                $student = Student::where('uuid', $student_id)->first();
                $results = PrimaryResult::where('student_id', $student->id())->where('term_id', $term)->where('period_id', $period)->where('grade_id', $grade)->get();
                $idNumber = $student->user->code();
                $password = 'password123';
                $name = $student->last_name." ".$student->first_name. " ".$student->other_name;
                $message = "<p> $name's examination result is now available on his/her portal. Please visit the school's website on " . application('website')."/result to access the result with these credentials: Id Number: ".$idNumber." and password: ".$password." or password1234</p>";
                $subject = 'Evaluation Report Sheet';
        
                foreach($results as $result){
                    $result->update(['published' => true]);
                }
                    
                try {
                    NotifiableParentsTrait::notifyParents($student, $message, $subject);
                } catch (\Throwable $th) {
                    info($th->getMessage());
                }

                try {
                    $watMessage = "{business.name}\\{business.address}\\{business.phone_number} \\ \\$name's examination result is now available on his/her portal. Please visit the school's website on \\" . application('website') . "\\to access the result with this credential: \\Id Number: ".$idNumber." \\Password: ".$password." or password1234 \\ \\Kind Regards, \\Management.";
                    NumberBroadcast::notify($student, $watMessage);
                } catch (\Throwable $th) {
                    info($th->getMessage());
                }
        
                $check = Cummulative::where('student_uuid', $student_id)->where('term_id', $term)->where('period_id', $period)->where('grade_id', $grade)->get();
        
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
            }

            return response()->json(ApiResponse(200, "Results Published successfully!"), 200);
        } catch (\Throwable $th) {
            info("Result Multiple Publish Error: ".$th->getMessage());
            return response()->json(ApiResponse(500, "There was a problem publish the results. Please try again"), 500);
        }
    }

    public function multipleMidtermPublish(Request $request)
    {
        try {
            $ids = json_decode($request->studentsIds, true);
            $period = $request->period_id;
            $term = $request->term_id;
            $grade = $request->grade_id;
            
            foreach($ids as $student_id){
                $student = Student::where('uuid', $student_id)->first();
                $results = MidTerm::where('student_id', $student->id())->where('term_id', $term)->where('period_id', $period)->where('grade_id', $grade)->get();
                $idNumber = $student->user->code();
                $password = 'password123';
                $name = $student->last_name." ".$student->first_name. " ".$student->other_name;
                $message = "<p> $name's midterm result is now available on his/her dashboard. Please visit the school's website on " . application('website')."/result/view/midterm to access the result with these credentials: Id Number: ".$idNumber." and password: ".$password." or password1234</p>";
                $subject = 'Evaluation Report Sheet';
        
                foreach($results as $result){
                    $result->update(['published' => true]);
                }
                    
                try {
                    NotifiableParentsTrait::notifyParents($student, $message, $subject);
                } catch (\Throwable $th) {
                    info($th->getMessage());
                }

                try {
                    $watMessage = "{business.name}\\{business.address}\\{business.phone_number} \\ \\$name's examination result is now available on his/her portal. Please visit the school's website on \\" . application('website') . "\\to access the result with this credential: \\Id Number: ".$idNumber." \\Password: ".$password." or password1234 \\ \\Kind Regards, \\Management.";
                    NumberBroadcast::notify($student, $watMessage);
                } catch (\Throwable $th) {
                    info($th->getMessage());
                }
        
                $check = Cummulative::where('student_uuid', $student_id)->where('term_id', $term)->where('period_id', $period)->where('grade_id', $grade)->get();
        
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
            }

            return response()->json(ApiResponse(200, "Results Published successfully!"), 200);
        } catch (\Throwable $th) {
            info("Result Multiple Publish Error: ".$th->getMessage());
            return response()->json(ApiResponse(500, "There was a problem publish the results. Please try again"), 500);
        }
    }
}
