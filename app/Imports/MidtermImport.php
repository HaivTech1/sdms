<?php

namespace App\Imports;

use App\Models\MidTerm;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MidtermImport implements ToModel, WithHeadingRow
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
        $midtermFormat = get_settings('midterm_format');

        $subjectId = $row['subject_id'];
        $subject = Subject::where('id', $subjectId)->first();
        // $student = Student::whereRaw("CONCAT(last_name, ' ', first_name, ' ', other_name) LIKE ?", ['%'.$studentName.'%'])->first();
        if ($subject) {
            $result = new MidTerm([
                'period_id' => $periodId,
                'term_id' => $termId,
                'grade_id' => $gradeId,
                'student_id' => $studentId,
                'subject_id' => $subject->id(),
                'entry_1' => $row['entry_1'],
                'entry_2' => $row['entry_2'],
                'first_test' => $row['first_test'],
                'class_activity' => $row['class_activity'],
                'ca' => $row['ca'],
                'project' => $row['project'],
                'author_id' => auth()->id()
            ]);
            $result->save();
        }
    }
}