<?php

namespace App\Http\Livewire\Components\Student\Result;

use App\Models\Term;
use App\Models\User;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Student;
use Livewire\Component;

class Index extends Component
{
    public $user;
    public $period_id;
    public $term_id;
    public $grade_id;
    public $state = [];

    protected $queryString = [
        'period_id' => ['except' => ''],
        'term_id' => ['except' => ''],
        'grade_id' => ['except' => ''],
    ];


    public function mount(User $user)
    {
       $this->user = $user;
    }

    public function getStudentsProperty()
    {
        return Student::whereUser_id($this->user->id())->when($this->grade_id, function($query, $grade) {
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
        })->first();        
    }

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

        $this->period_id = $this->state['period_id'] ?? '1';
        $this->term_id = $this->state['term_id'] ?? '1';
        $this->grade_id = $this->state['grade_id'];
    }

    public function scratchCardVerify()
    {
        $this->dispatchBrowserEvent('show-scratch');
    }

    public function render()
    {
        return view('livewire.components.student.result.index',[
            'user' => $this->user,
            'student' => $this->students,
            'periods' => Period::all()->pluck('title', 'id'),
            'terms' => Term::all()->pluck('title', 'id'),
            'grades' => Grade::all()->pluck('title', 'id')
        ]);
    }
}
