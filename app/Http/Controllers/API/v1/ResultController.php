<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Livewire\Components\Student\Result\Midterm;

class ResultController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $request->validate([
                    'students' => 'required|array',
                    'type'       => 'required',
                    'session'       => 'required',
                    'term'       => 'required',
                    'level'       => 'required',
                    'grade'       => 'required',
                    'subject'       => 'required',
                ]);

                $students = $request->input('students');
                $type = $request->input('type');
                $period = $request->input('session');
                $term = $request->input('term');
                $grade = $request->input('grade');
                $subject = $request->input('subject');

                if ($type === 'midterm') {

                    $studentName = $student['name'];

                    foreach ($students as $key => $student) {
                        $midterm = Midterm::where([
                            'period_id' => $period,
                            'term_id' => $term,
                            'grade_id' => $grade,
                            'subject_id' => $subject,
                            'student_id' => $student['id']
                        ])->first();
                    
                        if ($midterm) {
                            continue;
                        }
                    
                        $midtermFormat = get_settings('midterm_format');
                    
                        $midtermData = [
                            'period_id' => $period,
                            'term_id' => $term,
                            'grade_id' => $grade,
                            'student_id' => $student['id'],
                            'subject_id' => $subject
                        ];
                    
                        foreach ($student['scores'] as $scoreType => $scoreData) {
                            if (isset($midtermFormat[$scoreType])) {
                                $score = $scoreData['value'];
                                $midtermData[$scoreType] = $score;
                            }
                        }
                    
                        $midterm = new MidTerm($midtermData);
                        $midterm->authoredBy(auth()->user());
                        $midterm->save();
                    }

                }elseif ($type === 'exam') {
                    


                }
            });

            return response()->json([
                'status' => true,
                'message' => 'Result submitted successfully!',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
