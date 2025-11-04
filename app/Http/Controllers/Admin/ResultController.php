<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cummulative;
use App\Models\Grade;
use App\Models\MidTerm;
use App\Models\Period;
use App\Models\PrimaryResult;
use App\Models\Student;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;
use App\Jobs\NotifyParentsJob;
use App\Jobs\SendWhatsappJob;

class ResultController extends Controller
{
    public function multipleExamPublish(Request $request)
    {
        try {
            $ids = json_decode($request->studentsIds, true);
            $period_id = $request->period_id;
            $term_id = $request->term_id;
            $grade_id = $request->grade_id;
            
            $period = Period::where('id', $period_id)->first();
            $term = Term::where('id', $term_id)->first();
            
            DB::transaction(function () use ($ids, $period_id, $term_id, $grade_id, $period, $term) {
                foreach($ids as $student_id){
                    $student = Student::where('uuid', $student_id['id'])->first();
                    if (!$student) continue;
                    
                    $results = PrimaryResult::where('student_id', $student->id())
                        ->where('term_id', $term_id)
                        ->where('period_id', $period_id)
                        ->where('grade_id', $grade_id)
                        ->get();
                    
                    // Update published status
                    foreach($results as $result){
                        $result->update(['published' => true]);
                    }
                    
                    $name = $student->fullName();
                    $idNumber = $student->user->code();
                    
                    $message = "
                        <p>
                            Dear Parent/Guardian,
                        </p>
                        <p>
                            The examination result for <strong>{$student->fullname()}</strong> is now available.
                        </p>
                        <p>
                            You may conveniently view the result through your child's online dashboard on
                            <a href='" . application('website') . "/result'>" . application('website') . "</a>.
                        </p>
                        <p>
                            For your ease, result updates are also shared via your registered WhatsApp number.
                        </p>
                        <p>
                            To log in directly, you can still use the following credentials:<br>
                            <strong>ID Number:</strong> {$student->user->code()}<br>
                            <strong>Password:</strong> password123 or password1234
                        </p>
                    ";
                    
                    $subject = 'Examination Result';
                    
                    $path = $this->generateExamResultLink($student, $period_id, $term_id, Grade::find($grade_id));
                    $publicUrl = null;
                    $filename = null;
                    if ($path && file_exists($path)) {
                        $filename = basename($path);
                        $publicUrl = asset('storage/results/' . $filename);
                    }
                    
                    $watMessage = "*" . $term->title . "-" . $period->title . " $subject*\n \n$name's examination result is now available. Please click the link below to view the result\n \n $publicUrl \nKind Regards,\nManagement.";
                    
                    // Use Bus::chain for coordinated job execution
                    $emailJob = new NotifyParentsJob($student->id(), $message, $subject, $filename);
                    $whatsappJob = new SendWhatsappJob($student->id(), $watMessage, "parent");
                    
                    Bus::chain([
                        $emailJob,
                        $whatsappJob,
                    ])->dispatch();
                }
            });

            return response()->json(ApiResponse(200, "Results Published successfully!"), 200);
        } catch (\Throwable $th) {
            info("Result Multiple Publish Error: ".$th->getMessage());
            return response()->json(ApiResponse(500, "There was a problem publishing the results. Please try again"), 500);
        }
    }

    public function multipleMidtermPublish(Request $request)
    {
        try {
            $ids = json_decode($request->studentsIds, true);
            $period_id = $request->period_id;
            $term_id = $request->term_id;
            $grade_id = $request->grade_id;
            
            $period = Period::where('id', $period_id)->first();
            $term = Term::where('id', $term_id)->first();
            
            DB::transaction(function () use ($ids, $period_id, $term_id, $grade_id, $period, $term) {
                foreach($ids as $student_id){
                    $student = Student::where('uuid', $student_id['id'])->first();
                    if (!$student) continue;
                    
                    $results = MidTerm::where('student_id', $student->id())
                        ->where('term_id', $term_id)
                        ->where('period_id', $period_id)
                        ->where('grade_id', $grade_id)
                        ->get();
                    
                    // Update published status
                    foreach($results as $result){
                        $result->update(['published' => true]);
                    }
                    
                    $name = $student->fullName();
                    $idNumber = $student->user->code();
                    
                    $message = "
                        <p>
                            Dear Parent/Guardian,
                        </p>
                        <p>
                            The midterm result for <strong>{$student->fullname()}</strong> is now available.
                        </p>
                        <p>
                            You may conveniently view the result through your child's online dashboard on
                            <a href='" . application('website') . "/result/view/midterm'>" . application('website') . "</a>.
                        </p>
                        <p>
                            For your ease, result updates are also shared via your registered WhatsApp number.
                        </p>
                        <p>
                            To log in directly, you can still use the following credentials:<br>
                            <strong>ID Number:</strong> {$student->user->code()}<br>
                        </p>
                    ";
                    
                    $subject = 'Mid-term Result';
                    
                    $path = $this->generateMidtermResultLink($student, $grade_id, $period_id, $term_id);
                    $publicUrl = null;
                    $filename = null;
                    if ($path && file_exists($path)) {
                        $filename = basename($path);
                        $publicUrl = asset('storage/results/' . $filename);
                    }
                    
                    $watMessage = "*" . $term->title . "-" . $period->title . " $subject*\n \n$name's result is now available. Please click the link below to view the result\n \n $publicUrl \nKind Regards,\nManagement.";
                    
                    // Use Bus::chain for coordinated job execution
                    $emailJob = new NotifyParentsJob($student->id(), $message, $subject, $filename);
                    $whatsappJob = new SendWhatsappJob($student->id(), $watMessage, "parent");
                    
                    Bus::chain([
                        $emailJob,
                        $whatsappJob,
                    ])->dispatch();
                    
                    // Handle cumulative scores
                    $this->handleCumulativeScores($student->id(), $term_id, $period_id, $grade_id, $results);
                }
            });

            return response()->json(ApiResponse(200, "Results Published successfully!"), 200);
        } catch (\Throwable $th) {
            info("Result Multiple Publish Error: ".$th->getMessage());
            return response()->json(ApiResponse(500, "There was a problem publishing the results. Please try again"), 500);
        }
    }

    /**
     * Handle cumulative scores for a student's results
     */
    private function handleCumulativeScores($student_id, $term_id, $period_id, $grade_id, $results)
    {
        // Delete existing cumulative records
        $existingCumulative = Cummulative::where('student_uuid', $student_id)
            ->where('term_id', $term_id)
            ->where('period_id', $period_id)
            ->where('grade_id', $grade_id)
            ->get();
            
        foreach($existingCumulative as $cumulative) {
            $cumulative->delete();
        }
        
        // Create new cumulative records
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

    /**
     * Generate exam result PDF link (copied from main ResultController)
     */
    public function generateExamResultLink($student, $period_id, $term_id, $grade = null)
    {
        // Get the main controller instance to access its method
        $mainController = app(\App\Http\Controllers\ResultController::class);
        return $mainController->generateExamResultLink($student, $period_id, $term_id, $grade);
    }

    /**
     * Generate midterm result PDF link (copied from main ResultController)
     */
    public function generateMidtermResultLink($student, $grade_id, $period_id, $term_id)
    {
        // Get the main controller instance to access its method
        $mainController = app(\App\Http\Controllers\ResultController::class);
        return $mainController->generateMidtermResultLink($student, $grade_id, $period_id, $term_id);
    }
}
