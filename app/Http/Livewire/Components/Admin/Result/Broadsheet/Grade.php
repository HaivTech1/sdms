<?php

namespace App\Http\Livewire\Components\Admin\Result\Broadsheet;

use App\Models\MidTerm;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PrimaryResult;

class Grade extends Component
{

    use WithPagination;

    public $count = 10;
    public $period_id;
    public $grade_id;
    public $term_id;
    public $studentResults = [];
    public $subjects = [];
    
    protected $queryString = [
        'period_id' => ['except' => ''],
        'grade_id' => ['except' => ''],
        'term_id' => ['except' => ''],
    ];

    public function fetchResult()
    {
        $this->validate([
            'period_id' => ['required'],
            'grade_id' => ['required'],
            'term_id' => ['required'],
        ],[
            'period_id.required' => 'Please select session',
            'grade_id.required' => 'Please select class',
            'term_id.required' => 'Please select term',
        ]);
        
        $this->period_id = $this->period_id;
        $this->grade_id = $this->grade_id;
        $this->term_id = $this->term_id;

        $students = Student::when($this->grade_id, function($query, $grade){
            $query->whereHas('grade', function($query) use ($grade){
                $query->where('id', $grade);
            });
        })->get();

        $getSubjects = $students[0]->subjects->toArray();
        foreach ($getSubjects as $subject){
            $this->subjects[] = $subject['title'];
        }

        $midtermResults = MidTerm::when($this->grade_id, function($query, $grade){
            $query->whereHas('grade', function($query) use ($grade){
                $query->where('id', $grade);
            });
        })->when($this->period_id, function($query, $period){
            $query->whereHas('period', function ($query) use ($period){
                $query->where('id', $period);
            });
        })->when($this->term_id, function($query, $term){
            $query->whereHas('term', function ($query) use ($term){
                $query->where('id', $term);
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
        })->when($this->term_id, function($query, $term){
            $query->whereHas('term', function ($query) use ($term){
                $query->where('id', $term);
            });
        })->get();

        $midtermFormat = get_settings('midterm_format');
        $examFormat = get_settings('exam_format');

        $studentResults = [];

        foreach ($students as $student) {
            $studentResult = [
                'student_id' => $student->id(),
                'student_name' => $student->last_name . ' ' . $student->first_name . ' ' . $student->other_name,
                'results' => [],
            ];

            $mergedResults = $midtermResults->merge($examResults);
            
            foreach ($mergedResults as $result) {
                if ($result->student_id === $student->id()) {
                    $subjectId = $result->subject->id();
                    $subjectTitle = $result->subject->title();

                    $studentResult['results'][$subjectTitle] = [
                        'subject_id' => $subjectId,
                        'subject' => $subjectTitle,
                    ];

                    $resultItem = &$studentResult['results'][$subjectId];
                    
                    if ($result instanceof Midterm) {
                        if (is_array($midtermFormat)) {
                            foreach ($midtermFormat as $midtermKey => $midtermValue) {
                                if (isset($result->$midtermKey)) {
                                    $resultItem[$midtermKey] = $result->$midtermKey;
                                }
                            }
                        }
                    }

                    if ($result instanceof PrimaryResult) {
                        $resultItem['exam'] = $result->exam;
                    }
                }
            }

            $studentResults[] = $studentResult;
        }

        dd($studentResults);

        $this->studentResults = $studentResults;
    }
    
    public function render()
    {
        return view('livewire.components.admin.result.broadsheet.grade');
    }
}