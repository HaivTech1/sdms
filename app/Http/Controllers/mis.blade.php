public function gradeResultStatistic($grade_id, $period_id)
    {
        try {
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

            return response()->json([
                'status' => true,
                'students' => $students,
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

            return response()->json([
                'status' => true,
                'students' => $students,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }