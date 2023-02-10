<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Student;
use Livewire\Component;
use App\Models\Cognitive;
use App\Models\Psychomotor;
use Livewire\WithPagination;

class CheckPrimary extends Component
{

    use WithPagination;

    public $count = 10;
    public $period_id;
    public $term_id;
    public $grade_id;

    public $subjects = [];
    public $state = [];
    public $psych = [];

    // protected $queryString = [
    //     'period_id' => ['except' => ''],
    //     'term_id' => ['except' => ''],
    //     'grade_id' => ['except' => ''],
    // ];

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
                $query->whereHas('primaryResults', function($query) use ($period){
                    $query->whereHas('period', function ($query) use ($period){
                        $query->where('id', $period);
                    });
                 });
            })
            ->when($this->term_id, function($query, $term){
                $query->whereHas('primaryResults', function($query) use ($term){
                    $query->whereHas('term', function ($query) use ($term){
                        $query->where('id', $term);
                    });
                });
            });
        })->paginate($this->count);        
    }
    
    public function render()
    {
        return view('livewire.components.admin.result.check-primary',[
            'students' => $this->students,
            'grades' => Grade::get(),
            'periods' => Period::all(),
            'terms' => Term::all(),
            'psychomotors' => Psychomotor::where('term_id', $this->term_id)->where('period_id', $this->period_id)->get(),
            'cognitives' => Cognitive::where('term_id', $this->term_id)->where('period_id', $this->period_id)->get(),
        ]);
    }
}
