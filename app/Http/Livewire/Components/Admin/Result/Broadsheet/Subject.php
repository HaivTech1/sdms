<?php

namespace App\Http\Livewire\Components\Admin\Result\Broadsheet;

use App\Models\MidTerm;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PrimaryResult;

class Subject extends Component
{

    use WithPagination;

    public $count = 10;
    public $period_id;
    public $grade_id;
    public $subject_id;

    public $studentResults = [];

    protected $queryString = [
        'period_id' => ['except' => ''],
        'grade_id' => ['except' => ''],
        'subject_id' => ['except' => ''],
    ];

    public function fetchResult()
    {
        $this->validate([
            'period_id' => ['required'],
            'grade_id' => ['required'],
            'subject_id' => ['required'],
        ],[
            'period_id.required' => 'Please select Session',
            'grade_id.required' => 'Please select Class',
            'subject_id.required' => 'Please select Subject',
        ]);
        
        $this->period_id = $this->period_id;
        $this->grade_id = $this->grade_id;
        $this->subject_id = $this->subject_id;

        $students = Student::when($this->grade_id, function($query, $grade){
            $query->whereHas('grade', function($query) use ($grade){
                $query->where('id', $grade);
            });
        })->get();

        $midtermResults = MidTerm::when($this->grade_id, function($query, $grade){
            $query->whereHas('grade', function($query) use ($grade){
                $query->where('id', $grade);
            });
        })->when($this->period_id, function($query, $period){
            $query->whereHas('period', function ($query) use ($period){
                $query->where('id', $period);
            });
        })->when($this->subject_id, function($query, $subject){
            $query->whereHas('subject', function ($query) use ($subject){
                $query->where('id', $subject);
            });
        })->get();

        $examResults = PrimaryResult::when($this->grade_id, function($query, $grade){
            $query->whereHas('grade', function($query) use ($grade){
                $query->where('id', $grade);
            });
        })->when($this->period_id, function($query, $period){
            $query->whereHas('period', function ($query) use ($period){
                $query->where('id', $period);
            });
        })->when($this->subject_id, function($query, $subject){
            $query->whereHas('subject', function ($query) use ($subject){
                $query->where('id', $subject);
            });
        })->get();

        $midtermFormat = get_settings('midterm_format');
        $examFormat = get_settings('exam_format');

        $studentResults = [];
        $terms = [
            1 => 'first_term',
            2 => 'second_term',
            3 => 'third_term'
        ]; // Mapping term_id to term name

        foreach ($students as $student) {
            $studentResult = [
                'student_id' => $student->id(),
                'student_name' => $student->last_name . ' ' . $student->first_name . ' ' . $student->other_name,
                'results' => [],
            ];


            foreach ($terms as $termId => $termName) {
                $studentResult['results'][$termName] = []; 
            }

            $mergedResults = $midtermResults->merge($examResults);
            foreach ($mergedResults as $result) {
                if ($result->student_id === $student->id()) {
                    $subjectId = $result->subject->id;
                    $subjectTitle = $result->subject->title;
                    $termId = $result->term_id;

                    if (isset($terms[$termId])) {
                        $termName = $terms[$termId];

                        if (!isset($studentResult['results'][$termName][$subjectId])) {
                            $studentResult['results'][$termName][$subjectId] = [
                                'subject_id' => $subjectId,
                                'subject' => $subjectTitle,
                            ];
                        }

                        $resultItem = &$studentResult['results'][$termName][$subjectId];

                        // Add midterm scores to the result item
                        if ($result instanceof Midterm) {
                            if (is_array($midtermFormat)) {
                                foreach ($midtermFormat as $midtermKey => $midtermValue) {
                                    if (isset($result->$midtermKey)) {
                                        $resultItem[$midtermKey] = $result->$midtermKey;
                                    }
                                }
                            }
                        }

                        // Add exam score to the result item
                        if ($result instanceof PrimaryResult) {
                            foreach ($examFormat as $examKey => $examValue) {
                                if (isset($result->$examKey)) {
                                    $resultItem[$examKey] = $result->$examKey;
                                }
                            }
                        }
                        
                    }
                }
            }
            $studentResults[] = $studentResult;
        }

        $this->studentResults = $studentResults;
    }
    
    public function render()
    {
        return view('livewire.components.admin.result.broadsheet.subject');
    }
}