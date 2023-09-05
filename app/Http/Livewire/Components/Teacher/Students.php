<?php

namespace App\Http\Livewire\Components\Teacher;

use App\Models\Club;
use App\Models\Grade;
use App\Models\House;
use App\Models\Student;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;
use App\Scopes\HasActiveScope;
use App\Scopes\AssignedSubjectsScope;

class Students extends Component
{
    use WithPagination;

    public $per_page = 10;
    public $search = '';
    public $gender = '';
    public $sortBy = 'asc';
    public $orderBy = 'first_name';
    public $grade = '';
    public $student_details;
    public $status = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'gender' => ['except' => ''],
        'grade' => ['except' => ''],
    ];

    protected $listeners = [
        'refreshData' => 'refresh',
    ];

    public function refresh()
    {
        $this->reset();
    }

    public function getStudentsProperty()
    {
        return Student::when($this->gender, function($query, $gender) {
                return $query->where('gender', $gender);
        })
        ->where('grade_id', auth()->user()->gradeClassTeacher[0]->id())
        ->search(trim($this->search))->loadLatest($this->per_page, $this->orderBy, $this->sortBy, $this->status, $this->gender);
    }

    public function render()
    {
        return view('livewire.components.teacher.students', [
            'students' => $this->students,
            'grades' => Grade::all(),
            'houses' => House::all(),
            'clubs' => Club::all(),
            'subjects' => Subject::withoutGlobalScope(new AssignedSubjectsScope)->orderBy('title')->get()
        ]);
    }
}