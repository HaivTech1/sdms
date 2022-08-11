<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use Livewire\Component;

class Create extends Component
{

    public $period_id = null;
    public $selectedPeriod = null;

    public $term_id = null;
    public $selectedTerm = null;

    public $subject_id = null;
    public $selectedSubject = null;

    public $grade_id = null;
    public $selectedGrade = null;

    public $subjects = [];
    public $students = [];

    public function submitResult()
    {
        $class = Grade::where('id', $this->grade_id)->first();
        $this->subjects = $class->subjects->where('status', true);
        $this->students = $class->students->where('status', true);
        $this->grade_id = $this->grade_id;
        $this->selectedGrade = $class;


        $this->selectedPeriod = Period::where('id', $this->period_id)->first();
        $this->selectedTerm = Term::where('id', $this->term_id)->first();
        $this->selectedSubject = Subject::where('id', $this->subject_id)->first();
    }

    public function getResultsProperty()
    {
        return Result::when($this->period_id, function($query, $period) {
            $query->whereHas('period', function($query) use ($period){
               $query->where('id', $period);
            });
        })
        ->when($this->term_id, function($query, $term) {
            $query->whereHas('term', function($query) use ($term){
               $query->where('id', $term);
            });
        })
        ->when($this->grade_id, function($query, $grade) {
            $query->whereHas('grade', function($query) use ($grade){
               $query->where('id', $grade);
            });
        })
        ->when($this->subject_id, function($query, $subject) {
            $query->whereHas('subject', function($query) use ($subject){
               $query->where('id', $subject);
            });
        })
        ->get();        
    }
    

    public function render()
    {
        return view('livewire.components.admin.result.create', [
            'results' => $this->results,
            'grades' => Grade::all(),
            'periods' => Period::all(),
            'terms' => Term::all(),
        ]);
    }
}