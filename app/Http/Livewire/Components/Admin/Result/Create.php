<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{

    use WithPagination;
    
    public $count = 7;
    
    public $period_id = '';
    public $selectedPeriod = null;

    public $term_id = '';
    public $selectedTerm = null;

    public $subject_id = '';
    public $selectedSubject = null;

    public $grade_id = '';
    public $selectedGrade = null;

    public $students = [];

    public $state = [];

    protected $queryString = [
        'period_id' => ['except' => ''],
        'term_id' => ['except' => ''],
        'grade_id' => ['except' => ''],
        'subject_id' => ['except' => ''],
    ];

    public function fetchData()
    {
        $this->grade_id = $this->grade_id ? $this->grade_id : '';
        $class = Grade::where('id', $this->grade_id)->first();
        $checkSubject = $this->subject_id;
        $students = Student::where('grade_id', $class->id())->where('status', true)->whereHas('subjects', function ($query) use ($checkSubject) {
            $query->where('id', $checkSubject);
        })->get();
        $this->students = $students->sortBy('last_name');
        $this->selectedGrade = $class;
    }

    public function updatedPeriodId($period_id)
    {
        $this->selectedPeriod = Period::where('id', $period_id)->first();
    }

    public function updatedTermId($term_id)
    {
        $this->selectedTerm = Term::where('id', $term_id)->first();
    }

    public function updatedSubjectId($subject_id)
    {
        $this->selectedSubject = Subject::where('id', $subject_id)->first();
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
        })->paginate($this->count);        
    }
    

    public function render()
    {
        $user = auth()->user();
        return view('livewire.components.admin.result.create', [
            'results' => $this->results,
            'grades' => Grade::all(),
            'periods' => Period::all(),
            'terms' => Term::all(),
            'subjects' => Subject::when(!$user->isAdmin() && !$user->isSuperAdmin(), function ($query) use ($user) {
                $query->whereHas('teachers', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            })->get(),
        ]);
    }
}