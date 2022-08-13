<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Student;
use App\Models\Subject;
use Livewire\Component;

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

    public function updatedGradeId($grade_id)
    {
        $class = Grade::where('id', $grade_id)->first();
        $this->students = $class->students->where('status', true)->sortBy('first_name');
        $this->grade_id = $grade_id;
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


    public function updatedStudentId($student_id)
    {
        $this->selectedStudent = Student::where('uuid', $student_id)->first();
    }

    public function getStudentsProperty()
    {
        return Student::where('grade_id', $this->grade_id)->get(); 
    }
    
    
    public function render()
    {
        return view('livewire.components.admin.result.single-upload',[
            'students' => $this->students,
            'grades' => Grade::all(),
            'periods' => Period::all(),
            'terms' => Term::all(),
        ]);
    }
}