<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use Livewire\Component;

class Check extends Component
{
    public $period_id;
    public $term_id;
    public $grade_id;

    public $subjects = [];
    public $state = [];

    public function fetchResult()
    {
        $this->period_id = $this->state['period_id'];
        $this->term_id = $this->state['term_id'];
        $this->grade_id = $this->state['grade_id'];
    }

    public function getStudentsProperty()
    {
        return Student::totalResults($this->period_id, $this->term_id)->get();        
    }
    
    public function render()
    {
        return view('livewire.components.admin.result.check',[
            'students' => $this->students,
            'grades' => Grade::all(),
            'periods' => Period::all(),
            'terms' => Term::all(),
        ]);
    }
}