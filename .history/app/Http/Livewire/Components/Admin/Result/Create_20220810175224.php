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
    public $term_id = '';
    public $grade_id = '';
    public $state = [];

    public function getStudentsProperty()
    {
        return Student::when($this->grade_id, function($query, $grade) {
            return $query->where('grade_id', $grade);
        })->get();
    }

    public function createResult()
    {
        $makeResult = Validator::make($this->state, [
            'session_id' => 'required'
            'term_id' => 'required'
            'grade_id' => 'required'
            'student_id' => 'required'
            'subjuect_id' => 'required'
        ])
    }
    

    public function render()
    {
        return view('livewire.components.admin.result.create', [
            'students' => $this->students,
            'grades' => Grade::all(),
            'periods' => Period::all(),
            'terms' => Term::all(),
        ]);
    }
}