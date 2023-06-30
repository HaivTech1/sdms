<?php

namespace App\Http\Controllers\API\v1;

use App\Models\MidTerm;
use Illuminate\Http\Request;
use App\Models\PrimaryResult;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ExamResource;
use App\Http\Resources\v1\MidtermResource;

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
                    'type'       => 'required',
                    'session'       => 'required',
                    'term'       => 'required',
                    'level'       => 'required',
                    'subject'       => 'required',
                    'format'       => 'required',
                ]);

                $students = $request->input('students');
                $type = $request->input('type');
                $period = $request->input('session');
                $term = $request->input('term');
                $grade = $request->input('level');
                $subject = $request->input('subject');
                $format = $request->input('format');
                $midtermFormat = get_settings('midterm_format');

                if ($type === 'midterm') {
                    foreach ($students as $student) {
                        $midterm = MidTerm::where([
                            'period_id' => $period,
                            'term_id' => $term,
                            'grade_id' => $grade,
                            'subject_id' => $subject,
                            'student_id' => $student['id']
                        ])->first();
                    
                        if (!$midterm) {

                            $midtermData = [
                                'period_id' => $period,
                                'term_id' => $term,
                                'grade_id' => $grade,
                                'student_id' => $student['id'],
                                'subject_id' => $subject
                            ];

                            if (isset($student[$format])) {
                                $score = $student[$format]['value'];
                                $midtermData[$format] = $score;
                            }
                            $midterm = new MidTerm($midtermData);
                            $midterm->authoredBy(auth()->user());
                            $midterm->save();
                        }else{
                            if (isset($student[$format])) {
                                $score = $student[$format]['value'];
                                $midterm->$format = $score;
                                $midterm->save();
                            }
                        }

                    }

                }elseif ($type === 'examination') {
                    
                    foreach ($students as $key => $student) {
                        $check = PrimaryResult::where([
                            'period_id' => $period,
                            'term_id' => $term,
                            'grade_id' => $grade,
                            'subject_id' => $subject,
                            'student_id' => $student['id']
                        ])->first();

                        $midterm = MidTerm::where([
                            'period_id' => $period,
                            'term_id' => $term,
                            'grade_id' => $grade,
                            'subject_id' => $subject,
                            'student_id' => $student['id']
                        ])->first();

                        if ($check) {
                            $midtermDate = [];
                            if (is_array($midtermFormat)) {
                                foreach ($midtermFormat as $key => $value) {
                                    if (isset($midterm->$key)) {
                                        $midtermDate[$key] = $midterm->$key;
                                    }
                                }
                            }

                            if (isset($student[$format])) {
                                $score = $student[$format]['value'];
                                $midtermDate[$format] = $score;
                            }
                        
                            $check->update($midtermDate);
                        }else{
                            $result = new PrimaryResult([
                                'period_id'     => $period,
                                'term_id'       => $term,
                                'grade_id'      => $grade,
                                'subject_id'    => $subject,
                                'student_id'    => $student['id'],
                            ]);

                            if (is_array($midtermFormat)) {
                                foreach ($midtermFormat as $key => $value) {
                                    if (isset($midterm->$key)) {
                                        $result->$key = $midterm->$key;
                                    }
                                }
                            }

                            if (isset($student[$format])) {
                                $score = $student[$format]['value'];
                                $result->$format = $score;
                            }
                        
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

    public function index(Request $request)
    {
        try {

            $type = $request->type;
            $grade = $request->level;
            $period = $request->session;
            $term = $request->term;
            $subject = $request->subject;

            $midtermFormat = get_settings('midterm_format');
            $examFormat = get_settings('exam_format');
            $midterms = MidTerm::where([
                'period_id' => $period,
                'term_id' => $term,
                'grade_id' => $grade,
                'subject_id' => $subject,
            ])->get();

            $exams = PrimaryResult::where([
                'period_id' => $period,
                'term_id' => $term,
                'grade_id' => $grade,
                'subject_id' => $subject,
            ])->get();

            if ($type === 'midterm') {
                $results = [];
                foreach ($midterms as $midterm) {
                    $result = [
                        'id' => $midterm->id(),
                        'student_id' => $midterm->student->id(),
                        'student' => $midterm->student->firstName() . ' ' . $midterm->student->lastName() . ' ' . $midterm->student->otherName(),
                    ];

                    foreach ($midtermFormat as $format => $formatData) {
                        $result[$format] = $midterm->{$format};
                    }

                    $results[] = $result;
                }
            }else{
               
                $results = [];
                foreach ($exams as $exam) {
                    $result = [
                        'id' => $exam->id(),
                        'student_id' => $exam->student->id(),
                        'student' => $exam->student->firstName() . ' ' . $exam->student->lastName() . ' ' . $exam->student->otherName(),
                    ];

                    foreach ($examFormat as $format => $formatData) {
                        $result[$format] = $exam->{$format};
                    }

                    // foreach ($midterms as $midtermEntry) {
                    //     if ($midtermEntry->student->id() === $exam->student->id()) {
                    //         foreach ($midtermFormat as $format => $formatData) {
                    //             $result[$format] = $midtermEntry->{$format};
                    //         }
                    //         break;
                    //     }
                    // }

                    $results[] = $result;
                }
            }

            

            return response()->json([
                'status' => true,
                'results' => $results,
                'message' => 'Results returned successfully!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
