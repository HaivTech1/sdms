<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Result;
use App\Models\Student;
use Livewire\Component;

class Create extends Component
{

    public $period_id = '';
    public $term_id = '';
    public $grade_id = '';

    public function getResultsProperty()
    {
        return Student::when($this->grade_id, function($query, $grade) {
            return $query->where('grade_id', $grade);
        })->search(trim($this->search))->loadLatest($this->per_page, $this->orderBy, $this->sortBy);
    }
    

    public function render()
    {
        return view('livewire.components.admin.result.create', [
            'grades' => Grade::all(),
            'periods' => Period::all(),
            'terms' => Term::all(),
        ]);
    }
}