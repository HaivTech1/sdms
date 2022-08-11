<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Result;
use App\Models\Student;
use Livewire\Component;

class Create extends Component
{

    public $period_id = '';
    public $selectedPeriod = null;

    public $term_id = '';
    public $selectedPeriod = null;

    public $subject_id = '';
    public $selectedSubject = null;

    public $grade_id = '';
    public $selectedGrade = null;

    public $subjects = [];
    public $students = [];

    protected $rules = [
        'session_id' => 'required',
        'term_id' => 'required',
        'grade_id' => 'required',
        'student_id' => 'required',
        'subject_id' => 'required'
    ];

    public function updatedGradeId($grade_id)
    {
        $class = Grade::where('id', $grade_id)->first();
        $this->subjects = $class->subjects->where('status', true);
        $this->students = $class->students->where('status', true);
        $this->grade_id = $grade_id;
    }

    public function updatedTermId($term_id)
    {
        $this->selectedTerm = Term::where('id', $term_id)->first();
    }

    public function createResult()
    {
            dd($this->state);
    }
    

    public function render()
    {
        return view('livewire.components.admin.result.create', [
            'grades' => Grade::all(),
            'periods' => Period::all(),
            'terms' => Term::all(),
        ]);
    }
}