<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Student;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Psychomotor;
use App\Models\PrimaryResult;

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

    public $results = null;

    protected $queryString = [
        'period_id' => ['except' => ''],
        'term_id' => ['except' => ''],
        'grade_id' => ['except' => ''],
        'student_id' => ['except' => ''],
    ];

    public function updatedGradeId($grade_id)
    {
        $class = Grade::where('id', $grade_id)->first();
        $this->students = $class->students->where('status', true)->sortBy('last_name');
        $this->grade_id = $grade_id;
        $this->selectedGrade = $class;
    }

    public function updatedStudentId($student_id)
    {
        $this->selectedStudent = Student::where('uuid', $student_id)->first();
    }

    public function selectStudent()
    {

        $this->validate([
            'period_id' => ['required'],
            'student_id' => ['required'],
            'term_id' => ['required'],
        ],[
            'period_id.required' => 'Please select Session',
            'student_id.required' => 'Please select Student',
            'term_id.required' => 'Please select Term',
        ]);

        $this->selectedStudent = Student::where('uuid', $this->student_id)->first();
        $this->selectedPeriod = Period::where('id', $this->period_id)->first();
        $this->selectedTerm = Term::where('id', $this->term_id)->first();
        $res = PrimaryResult::where('student_id', $this->student_id)->where('period_id', $this->period_id)->where('term_id', $this->term_id)->get();
        $this->results = $res;
    }

    public function getStudentsProperty()
    {
        return Student::where('grade_id', $this->grade_id)->get(); 
    }
    
    
    public function render()
    {
        $grades = Grade::get();

        return view('livewire.components.admin.result.single-upload',[
            'students' => $this->students,
            'grades' => $grades,
            'periods' => Period::all(),
            'terms' => Term::all(),
            'psychomotors' => Psychomotor::all(),
        ]);
    }
}