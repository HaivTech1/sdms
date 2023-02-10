<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Student;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Psychomotor;

class SingleUpload extends Component
{
    public $count = 10;

    public $period_id = null;
    public $selectedPeriod = null;

    public $term_id = null;
    public $selectedTerm = null;

    public $subject_id = null;
    
    public $grade_id = null;
    public $selectedGrade = null;
    
    public $student_id = null;

    public $subjects = [];
    public $selectedStudent;
    public $state = [];

    public function updatedGradeId($grade_id)
    {
        $class = Grade::where('id', $grade_id)->first();
        $this->students = $class->students->where('status', true)->sortBy('first_name');
        $this->grade_id = $grade_id;
        $this->selectedGrade = $class;
    }

    public function selectStudent()
    {

        $this->validate([
            'state.period_id' => ['required'],
            'state.student_id' => ['required'],
            'state.term_id' => ['required'],
        ],[
            'state.period_id.required' => 'Please select Session',
            'state.student_id.required' => 'Please select Student',
            'state.term_id.required' => 'Please select Term',
        ]);

        $this->selectedStudent = Student::where('uuid', $this->state['student_id'])->first();
        $this->selectedPeriod = Period::where('id', $this->state['period_id'])->first();
        $this->selectedTerm = Term::where('id', $this->state['term_id'])->first();
    }

    public function getStudentsProperty()
    {
        return Student::where('grade_id', $this->grade_id)->get(); 
    }
    
    
    public function render()
    {
        
        return view('livewire.components.admin.result.single-upload',[
            'students' => $this->students,
            'grades' => Grade::get(),
            'periods' => Period::all(),
            'terms' => Term::all(),
            'psychomotors' => Psychomotor::all(),
        ]);
    }
}