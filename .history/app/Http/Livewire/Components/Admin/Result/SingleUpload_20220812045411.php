<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use Livewire\Component;

class SingleUpload extends Component
{
    public $period_id = null;
    public $selectedPeriod = null;

    public $term_id = null;
    public $selectedTerm = null;

    public $subject_id = null;
    public $selectedSubject = null;

    public $grade_id = null;
    public $selectedGrade = null;

    public $subjects = [];
    public $students = [];
    
    public function render()
    {
        return view('livewire.components.admin.result.single-upload',[
            'grades' => Grade::all(),
            'periods' => Period::all(),
            'terms' => Term::all(),
        ]);
    }
}