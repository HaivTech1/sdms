<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MidTerm;

class BatchMidtermUpload extends Component
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
        $this->students = $class->students->where('status', true)->sortBy('last_name');
        $this->selectedGrade = $class;
    }

    public function getResultsProperty()
    {
        return MidTerm::when($this->period_id, function($query, $period) {
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
        })->get();        
    }
    
    public function render()
    {
        return view('livewire.components.admin.result.batch-midterm-upload',[
            'results' => $this->results,
            'grades' => Grade::all(),
            'periods' => Period::all(),
            'terms' => Term::all(),
            'subjects' => Subject::all(),
        ]);
    }
}