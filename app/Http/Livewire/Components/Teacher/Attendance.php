<?php

namespace App\Http\Livewire\Components\Teacher;

use App\Models\User;
use App\Models\Student;
use Livewire\Component;

class Attendance extends Component
{

    public $students;
    public $teacher; 
    public $grade; 


    public function mount()
    {
        if(!auth()->user()->isSuperAdmin() || !auth()->user()->isAdmin()){
            $this->grade = auth()->user()->gradeClassTeacher[0]->id();
            $this->students = Student::where('grade_id', $this->grade)->get();
        }
    }

    public function updatedTeacher($id)
    {
        $teac = User::whereId($id)->first();
        $this->grade = $teac->gradeClassTeacher[0]->id();
        $this->students = Student::where('grade_id', $this->grade)->get();
    }

    public function getTeachersProperty()
    {
        return User::whereType('3')->get();
    }

    public function render()
    {
        
        return view('livewire.components.teacher.attendance',[
            'teachers' => $this->teachers,
            'students' => $this->students
        ]);
    }
}
