<?php

namespace App\Http\Controllers\API\v1;

use App\Models\MidTerm;
use Illuminate\Http\Request;
use App\Models\PrimaryResult;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {

                $request->validate([
                    'students' => 'required|array',
                    'students.*.id' => 'required',
                    'students.*.name' => 'required',
                    'students.*.scores' => 'required|array',
                    'type'       => 'required',
                    'session'       => 'required',
                    'term'       => 'required',
                    'level'       => 'required',
                    'subject'       => 'required',
                ]);

                $students = $request->input('students');
                $type = $request->input('type');
                $period = $request->input('session');
                $term = $request->input('term');
                $grade = $request->input('level');
                $subject = $request->input('subject');

                if ($type === 'midterm') {

                    foreach ($students as $key => $student) {

                        $midterm = MidTerm::where([
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
                    
                    foreach ($students as $key => $student) {
                        $check = PrimaryResult::where([
                            'period_id' => $period,
                            'term_id' => $term,
                            'grade_id' => $grade,
                            'subject_id' => $subject,
                            'student_id' => $student['id']
                        ])->first();

                        if ($check) {
                            continue;
                        }

                        $midterm = MidTerm::where([
                            'period_id' => $period,
                            'term_id' => $term,
                            'grade_id' => $grade,
                            'subject_id' => $subject,
                            'student_id' => $student['id']
                        ])->first();

                        if ($midterm) {
                            continue;
                        }else{
                            $midterm_entry = $midterm->where('subject_id', $subject)->first();
                            $examFormat = get_settings('midterm_format');
                            
                            $examData = [
                                'period_id' => $period,
                                'term_id' => $term,
                                'grade_id' => $grade,
                                'student_id' => $student['id'],
                                'subject_id' => $subject
                            ];

                            foreach ($student['scores'] as $scoreType => $scoreData) {
                                if (isset($examFormat[$scoreType])) {
                                    $score = $scoreData['value'];
                                    $examData['ca1'] = $midterm_entry->firstTest() + $midterm_entry->entry1() + $midterm_entry->entry2();
                                    $examData['c2'] = $midterm_entry->ca();
                                    $examData['ca3'] = $midterm_entry->classActivity();
                                    $examData['pr'] = $midterm_entry->project();
                                    $examData[$scoreType] = $score;
                                }
                            }

                            $result = new MidTerm($examData);
                            $result->authoredBy(auth()->user());
                            $result->save();
                        }

                    }

                }
            });

            return response()->json([
                'status' => true,
                'message' => 'Result submitted successfully!',
            ], 200);
        } catch (\ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $errors,
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
