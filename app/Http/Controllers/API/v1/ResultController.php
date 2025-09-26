<?php

namespace App\Http\Controllers\API\v1;

use App\Models\{
    Student,
    Period,
    Term,
    Cognitive,
    Cummulative,
    Grade
};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResultController as ControllersResultController;
use Illuminate\Support\Facades\Validator;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        try {

            $type = $request->type;
            $grade = $request->grade_id;
            $period = $request->period_id;
            $term = $request->term_id;

            $controller = new ControllersResultController();

            if($type === 'midterm') {
                $data = $controller->checkMidterm($grade, $period, $term);
            }else{
                $data = $controller->checkExam($grade, $period, $term);
            }

            return $data;

        } catch (\Exception $e) {
            info("Error fetching results: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $student = Student::where('uuid', $request->student_id)->first();

            if ($request->term_id == 1) {
                $know = (int) $request->term_id + 1;
            } elseif ($request->term_id == 1) {
                $know = (int) $request->term_id + 1;
            } else {
                $know = 1;
            }

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
            $midtermFormat = get_settings('midterm_format');
            $examFormat = get_settings('exam_format');

            $first_term_cumm = Cummulative::where('term_id', $first_term)->where('student_uuid', $student->id())->where('period_id', $period->id)->get();
            $second_term_cumm = Cummulative::where('term_id', $second_term)->where('student_uuid', $student->id())->where('period_id', $period->id)->get();
            $studentResults = $student->primaryResults->where('term_id', $term->id())->where('period_id', $period->id)->toArray();

            $newFirst = array();
            foreach ($first_term_cumm as $key => $value) {
                $newFirst[] = [
                    'first_term' => $value->score,
                    'subject_id' => $value->subject_id,
                    'grade_id' => $value->grade_id,
                    'term_id' => $value->term_id,
                    'period_id' => $value->period_id,
                ];
            }

            $newSecond = array();
            foreach ($second_term_cumm as $key => $value) {
                $newSecond[] = [
                    'second_term' => $value->score,
                    'subject_id' => $value->subject_id,
                    'grade_id' => $value->grade_id,
                    'term_id' => $value->term_id,
                    'period_id' => $value->period_id,
                ];
            }

            $newResult = [];
            foreach ($studentResults as $key => $value) {
                $resultItem = [
                    'subject_id' => $value['subject']['id'],
                    'subject' => $value['subject']['title'],
                    'position_in_class_subject' => $value['position_in_class_subject'],
                    'position_in_grade_subject' => $value['position_in_grade_subject'],
                ];

                if (is_array($midtermFormat)) {
                    foreach ($midtermFormat as $midtermKey => $midtermValue) {
                        if (isset($value[$midtermKey])) {
                            $resultItem[$midtermKey] = $value[$midtermKey];
                        } else {
                            $resultItem[$midtermKey] = "";
                        }
                    }
                }

                if (is_array($examFormat)) {
                    foreach ($examFormat as $examKey => $examValue) {
                        if (isset($value[$examKey])) {
                            $resultItem[$examKey] = $value[$examKey];
                        } else {
                            $resultItem[$examKey] = "";
                        }
                    }
                }

                $newResult[] = $resultItem;
            }

            $firstTermResult = $newResult;
            $secondTermResult = $this->custom_array_merge($newFirst, $newResult);
            $thirdTermResult = $this->custom_array_merge($secondTermResult, $newSecond);

            if ($request->term_id === '1') {
                $results = $firstTermResult;
            } elseif ($request->term_id === '2') {
                $results = $secondTermResult;
            } elseif ($request->term_id === '3') {
                $results = $thirdTermResult;
            }

            $marksObtained = 0;
            $numSubjects = count($results);
            $grand = $numSubjects * 100;

            foreach ($results as $result) {
                if ($request->term_id === '2') {
                    $total = calculateResult($result) + $result['first_term'] / 2;
                } elseif ($request->term_id === '3') {
                    $total = secondary_average($result['first_term'], $result['second_term'], calculateResult($result), 2);
                } else {
                    $total = calculateResult($result);
                }
                $marksObtained += $total;
            }

            $aggregate = $marksObtained / $grand * 100;

            $studentGrade = get_grade($student->grade->title());
            $gradeStudents = Student::whereHas('grade', function ($query) use ($studentGrade) {
                $query->where('title', 'like', $studentGrade . '%');
            })->count();


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

            foreach ($results as $item) {
                $total_score = $item['ca1'] + $item['ca2'] + $item['exam'];
                $subject_id = $item['subject_id'];
                $scores[$subject_id] = $total_score;
            }


            $weakness_info = "Dear $student->first_name, based on your current term score, you need to improve in the following subject(s):";
            $comment = generate_comment($scores, $weakness_info, 0.5, 100, 'examination');

            return response()->json([
                'status' => true,
                'data' => [
                    'results' => $results,
                    'psychomotors' => $psychomotors,
                    'affectives' => $affectives,
                    'studentAttendance' => $studentAttendance,
                    'gradeStudents' => $gradeStudents,
                    'aggregate' => $aggregate,
                    'comment' => $comment,
                    'next_term_resummes' => \Carbon\carbon::parse(get_settings('next_term_resume'))->format('d F, Y'),
                    'no_students' => $student->grade->students->count()
                ],
                200
            ]);
        } catch (\Throwable $th) {
            info("Error fetching result: " . $th->getMessage());
            return response()->json(['status' => false, 'message' => "There was an error fetching the result.", 'error' => $th->getMessage()], 500);
        }
    }

    private function custom_array_merge($newResult, $newFirst)
    {
        $result = array();
        foreach ($newResult as $key_1 => $value_1) {
            foreach ($newFirst as $key_1 => $value_2) {
                if ($value_1['subject_id'] == $value_2['subject_id']) {
                    $result[] = array_merge($value_1, $value_2);
                }
            }

        }
        return $result;
    }

    public function whatsappResult(Request $request)
    {
        try {
            $data = $request->all();

            $validateData = Validator::make($data, [
                'student_id' => ['required', 'regex:/^SLNP/'],  // Must start with SLNP uppercase
                'session' => ['required'],
                'term' => ['required', 'in:first,second,third'],
                'grade' => ['required', 'integer', 'exists:grades,id'],
                'type' => ['required', 'in:midterm,exam'],
            ], [
                'student_id.required' => 'Student Registration number is required.',
                'student_id.regex' => 'Student ID must start with the uppercase letters "SLNP".',
                'session.required' => 'Academic session is required.',
                'term.required' => 'Term is required.',
                'term.in' => 'Term must be one of: First, Second, or Third.',
                'type.required' => 'Type of result is required.',
                'type.in' => 'Type must be either "midterm" or "exam".',
                'grade.required' => 'Please select a class.',
            ]);

            if ($validateData->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validateData->errors()->first()
                ], 400);
            }

            $student = Student::with(['user'])
                ->whereHas('user', function ($query) use ($data) {
                    $query->where('reg_no', $data['student_id']);
                })
                ->first();

            if (!$student) {
                return response()->json([
                    'status' => false,
                    'message' => 'Student not found with the given ID.'
                ], 404);
            }

            $period = Period::where('title', 'like', '%' . $data['session'] . '%')->first();

            if (!$period) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid session provided. Please check and try again.'
                ], 404);
            }

            $term = Term::where('title', 'like', '%' . $data['term'] . '%')->first();

            if (!$term) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid term provided. Please check and try again.'
                ], 404);
            }

            $grade = Grade::findOrFail($request->grade);

            $link = "";

            $resultController = app()->make(ControllersResultController::class);
            switch ($data['type']) {
                case 'midterm':
                    $link = $resultController->generateMidtermResultLink($student, $grade->id(), $student->grade_id, $period->id, $term->id);
                    break;
                case 'exam':
                    $link = $resultController->generateExamResultLink($student, $period->id,
                    $term->id, $grade);
                    break;
            }

            if ($link && file_exists($link)) {
                $filename = basename($link);
                $publicUrl = asset('storage/results/' . $filename);
            } else {
                $publicUrl = null;
            }

            if (!$publicUrl) {
                return response()->json([
                    'status' => false,
                    'message' => 'Result not found for the given session, term, and type.'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => "The result for {$term->title} - {$period->title} of ".$student->last_name . ' ' . $student->first_name .' found and generated successfully.',
                'download_url' => $publicUrl,
            ]);
        } catch (\Exception $e) {
            info('Error in whatsappResult: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }

    public function affective(Request $request)
    {
        $request->validate([
            'period_id' => 'required|integer',
            'term_id'   => 'required|integer',
            'grade_id'  => 'required|integer|exists:grades,id',
        ]);

        try {
            $students = Student::select('uuid', 'first_name', 'last_name', 'grade_id') // only basic info
                ->where('grade_id', $request->grade_id)
                ->with(['affectives' => function ($q) use ($request) {
                    $q->select('id', 'title', 'rate', 'student_uuid', 'period_id', 'term_id')
                    ->where('period_id', $request->period_id)
                    ->where('term_id', $request->term_id);
                }])
                ->get();

            return response()->json([
                'status'   => true,
                'message'  => 'Affective results retrieved successfully',
                'students' => $students,
            ], 200);

        } catch (\Exception $e) {
            info($e);
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cognitive(Request $request)
    {
        $request->validate([
            'period_id' => 'required|integer',
            'term_id'   => 'required|integer',
            'grade_id'  => 'required|integer|exists:grades,id',
        ]);

        try {
            $students = Student::select('uuid', 'first_name', 'last_name', 'grade_id')
                ->where('grade_id', $request->grade_id)
                ->with(['cognitives' => function ($q) use ($request) {
                    $q->select(
                        'id', 
                        'attendance_duration', 
                        'attendance_present', 
                        'comment', 
                        'principal_comment',
                        'promotion_comment',
                        'student_uuid',
                        'period_id',
                        'term_id'
                    )
                    ->where('period_id', $request->period_id)
                    ->where('term_id', $request->term_id);
                }])
                ->get();

            return response()->json([
                'status'   => true,
                'message'  => 'Cognitive results retrieved successfully',
                'students' => $students,
            ], 200);

        } catch (\Exception $e) {
            info($e);
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function psychomotor(Request $request)
    {
        $request->validate([
            'period_id' => 'required|integer',
            'term_id'   => 'required|integer',
            'grade_id'  => 'required|integer|exists:grades,id',
        ]);

        try {
            $students = Student::select('uuid', 'first_name', 'last_name', 'grade_id')
                ->where('grade_id', $request->grade_id)
                ->with(['psychomotors' => function ($q) use ($request) {
                    $q->select('id', 'title', 'rate', 'student_uuid', 'period_id', 'term_id')
                    ->where('period_id', $request->period_id)
                    ->where('term_id', $request->term_id);
                }])
                ->get();

            return response()->json([
                'status'   => true,
                'message'  => 'Psychomotor results retrieved successfully',
                'students' => $students,
            ], 200);

        } catch (\Exception $e) {
            info($e);
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}