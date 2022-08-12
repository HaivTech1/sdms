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
    public $period_id = null;
    public $selectedPeriod = null;

    public $term_id = null;
    public $selectedTerm = null;

    public $subject_id = null;
    public $selectedSubject = null;

    public $grade_id = null;
    public $selectedGrade = null;

    public $student_id = null;
    public $selectedStudent = '';

    public $subjects = [];
    public $students = [];

    public function updatedGradeId($grade_id)
    {
        $class = Grade::where('id', $grade_id)->first();
        $this->subjects = $class->subjects->where('status', true);
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

    public function updatedSubjectId($subject_id)
    {
        $this->selectedSubject = Subject::where('id', $subject_id)->first();
    }

    public function updatedStudentId($student_id)
    {
        $this->selectedStudent = Student::where('first_name', $student_id)->first();
    }
    
    
    public function render()
    {
        return view('livewire.components.admin.result.single-upload',[
            'grades' => Grade::all(),
            'periods' => Period::all(),
            'terms' => Term::all(),
        ]);
    }
}