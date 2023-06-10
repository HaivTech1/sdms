<?php

namespace App\Http\Livewire\Components\Admin\Student;

use App\Models\Grade;
use App\Models\Student;
use Livewire\Component;
use App\Models\Graduate;
use Livewire\WithPagination;
use App\Scopes\HasActiveScope;

class Promotion extends Component
{
    use WithPagination;
    
    public $selectedRows = [];
    public $selectPageRows = false;
    public $from;
    public $to;
    public $search = '';
    public $count = 10;

    protected $queryString = [
        'from' => ['except' => ''],
        'to' => ['except' => ''],
        'search' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->students->pluck('uuid')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getStudentsProperty()
    {
        return Student::when($this->from, function($query, $grade) {
            $query->whereHas('grade', function($query) use ($grade){
               $query->where('id', $grade);
            });
        })->search(trim($this->search))->get();        
    }

    public function promoteAll()
    {

        $this->validate([
            'from' => ['required'],
            'to' => ['required'],
            'selectedRows' => ['required'],
        ],[
            'from.required' => 'Please select the class to be promoted from',
            'to.required' => 'Please select the class to be promoted to',
            'selectedRows.required' => 'Please select the students to be promoted',
        ]);

        $toBePromoted = Student::withoutGlobalScope(new HasActiveScope)->whereIn('uuid', $this->selectedRows)->get();
        $lastGrade = Grade::whereTitle('graduated')->first();
        foreach ($toBePromoted as $value) {

            $value->update(['grade_id' => $this->to]);

            if ($this->to === $lastGrade->id()) {
                $graduate = new Graduate([
                    'student_id' => $value->id(),
                    'author_id' => auth()->id(),
                    'grade_id' => $this->from,
                    'term_id' => term('id'),
                    'period_id' => period('id'),
                ]);
                $graduate->save();
            }
        }

        $this->dispatchBrowserEvent('success', ['message' => 'All students promoted successfully!']);
        $this->reset(['selectedRows', 'selectPageRows', 'from', 'to']);
    }

    public function repeatAll()
    {

        $this->validate([
            'from' => ['required'],
            'to' => ['required'],
        ],[
            'from.required' => 'Please select the class to be promoted from',
            'to.required' => 'Please select the class to be promoted to',
        ]);

        $toBePromoted = ClientStudent::withoutGlobalScope(new HasActiveScope)->whereIn('uuid', $this->selectedRows)->get();

        foreach ($toBePromoted as $value) {
            $value->update(['grade_id' => $this->to]);
        }

        $this->dispatchBrowserEvent('success', ['message' => 'All students repeated successfully!']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }
    
    public function render()
    {
        return view('livewire.components.admin.student.promotion', [
            'students' => $this->students,
            'grades' => Grade::all()
        ]);
    }
}
