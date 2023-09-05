<?php

namespace App\Imports;

use App\Models\Subject;
use App\Models\PrimaryResult;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExamImport implements ToModel, WithHeadingRow
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function model(array $row)
    {
        $gradeId = $this->request->input('grade_id');
        $periodId = $this->request->input('period_id');
        $termId = $this->request->input('term_id');
        $studentId = $this->request->input('student_id');

        $subjectId = $row['subject_id'];
        $subject = Subject::where('id', $subjectId)->first();
        // $student = Student::whereRaw("CONCAT(last_name, ' ', first_name, ' ', other_name) LIKE ?", ['%'.$studentName.'%'])->first();

        if ($subject) {
            $result = new PrimaryResult([
                'period_id' => $periodId,
                'term_id' => $termId,
                'grade_id' => $gradeId,
                'student_id' => $studentId,
                'subject_id' => $subject->id(),
                'ca1'           => $row['first_test'] + $row['entry_1'] + $row['entry_2'],
                'ca2'           => $row['ca'],
                'ca3'           => $row['class_activity'],
                'pr'            => $row['project'],
                'exam' => $row['exam'],
                'author_id' => auth()->id()
            ]);
            $result->save();
        }
    }
}