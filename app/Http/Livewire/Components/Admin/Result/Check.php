<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;

class Check extends Component
{
    use WithPagination;

    public $count = 10;
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
        return Student::when($this->grade_id, function($query, $grade) {
            $query->whereHas('grade', function($query) use ($grade){
               $query->where('id', $grade);
            })
            ->when($this->period_id, function($query, $period){
                $query->whereHas('results', function($query) use ($period){
                    $query->whereHas('period', function ($query) use ($period){
                        $query->where('id', $period);
                    });
                 });
            })
            ->when($this->term_id, function($query, $term){
                $query->whereHas('results', function($query) use ($term){
                    $query->whereHas('term', function ($query) use ($term){
                        $query->where('id', $term);
                    });
                 });
            });
        })->paginate($this->count);        
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