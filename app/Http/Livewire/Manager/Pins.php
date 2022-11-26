<?php

namespace App\Http\Livewire\Manager;

use App\Models\Grade;
use App\Models\Pincode;
use App\Models\Student;
use Livewire\Component;

class Pins extends Component
{

    public $per_page = 10;
    public $students = [];
    public $grade;

    public function getPinsProperty()
    {
        return Pincode::when($this->grade, function($query, $grade) {
            return $query->whereHas('user', function($query) {
                $query->whereHas('student', function($query){
                    $query->where('grade_id',  $this->grade);
                });
            });
        })->limit($this->per_page)->get();
    }

    public function updatedGrade($id)
    {
        $this->students = Student::whereGrade_id($id)->get();
    }
    
    public function render()
    {
        return view('livewire.manager.pins',[
            'pins' => $this->pins,
            'grades' => Grade::all()
        ]);
    }
}
