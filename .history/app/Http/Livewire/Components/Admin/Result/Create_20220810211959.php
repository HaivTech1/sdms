<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Result;
use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Create extends Component
{

    public $period_id = '';
    public $term_id = '';
    public $subject_id = '';
    public $grade = null;
    public $subjects = [];
    public $students = [];
    public $state = [];

    public function updatedGrade($grade_id)
    {
        $class = Grade::where('id', $grade_id)->first();
        $class_subjects = $class->subjects;
        $this->subjects = $class_subjects;
    }

    public function createResult()
    {
        $makeResult = Validator::make($this->state, [
            'session_id' => 'required',
            'term_id' => 'required',
            'grade_id' => 'required',
            'student_id' => 'required',
            'subject_id' => 'required'
        ])->validate();




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