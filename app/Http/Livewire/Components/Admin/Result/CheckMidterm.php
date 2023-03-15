<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Student;
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class CheckMidterm extends Component
{
    use WithPagination;

    public $count = 10;
    public $period_id;
    public $term_id;
    public $grade_id;

    public $subjects = [];
    public $psych = [];
    public $search = '';
    public $orderBy = 'last_name';

    protected $queryString = [
        'period_id' => ['except' => ''],
        'term_id' => ['except' => ''],
        'grade_id' => ['except' => ''],
        'search' => ['except' => ''],
    ];

    // public function mount(Request $request)
    // {
    //    $this->grade_id = $request->get('grade_id');
    //    $this->period_id = $request->get('period_id');
    //    $this->period_id = $request->get('period_id');
    // }

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
        })->search(trim($this->search))->paginate($this->count);        
    }

    public function fetchResult()
    {
        $this->validate([
            'period_id' => ['required'],
            'term_id' => ['required'],
            'grade_id' => ['required'],
        ],[
            'period_id.required' => 'Please select Session',
            'term_id.required' => 'Please select Term',
            'grade_id.required' => 'Please select Class',
        ]);
        
        $this->period_id = $this->period_id;
        $this->term_id = $this->term_id;
        $this->grade_id = $this->grade_id;
    }

    public function render()
    {
        return view('livewire.components.admin.result.check-midterm',[
            'students' => $this->students,
            'grades' => Grade::get(),
            'periods' => Period::all(),
            'terms' => Term::all(),
        ]);
    }
}
