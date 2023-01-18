<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;

class CheckMidterm extends Component
{
    use WithPagination;

    public $count = 10;
    public $period_id;
    public $term_id;
    public $grade_id;

    public $subjects = [];
    public $state = [];
    public $psych = [];

    public function fetchResult()
    {
        $this->validate([
            'state.period_id' => ['required'],
            'state.term_id' => ['required'],
            'state.grade_id' => ['required'],
        ],[
            'state.period_id.required' => 'Please select Session',
            'state.term_id.required' => 'Please select Term',
            'state.grade_id.required' => 'Please select Class',
        ]);
        
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
                $query->whereHas('midTermResults', function($query) use ($period){
                    $query->whereHas('period', function ($query) use ($period){
                        $query->where('id', $period);
                    });
                 });
            })
            ->when($this->term_id, function($query, $term){
                $query->whereHas('midTermResults', function($query) use ($term){
                    $query->whereHas('term', function ($query) use ($term){
                        $query->where('id', $term);
                    });
                });
            });
        })->paginate($this->count);        
    }

    public function render()
    {
        return view('livewire.components.admin.result.check-midterm',[
            'students' => $this->students,
            'grades' => Grade::whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8, 9])->get(),
            'periods' => Period::all(),
            'terms' => Term::all(),
        ]);
    }
}
