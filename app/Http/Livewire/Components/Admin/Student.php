<?php

namespace App\Http\Livewire\Components\Admin;

use App\Models\Grade;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;
use App\Scopes\HasActiveScope;
use App\Models\Student as ClientStudent;

class Student extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 10;
    public $search = '';
    public $gender = '';
    public $sortBy = 'asc';
    public $orderBy = 'first_name';
    public $grade = '';
    public $student_details;
    public $subjects = [];
    public $status = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'gender' => ['except' => ''],
        'grade' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    protected $listeners = [
        'refreshData' => 'refresh',
    ];

    public function mount()
    {
        $this->subjects = Subject::orderBy('title')->get();
    }

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

    public function refresh()
    {
        $this->reset();
    }

    public function getStudentsProperty()
    {
        return ClientStudent::withoutGlobalScope(new HasActiveScope)->when($this->grade, function($query, $grade) {
            $query->whereHas('grade', function($query) use ($grade){
               $query->where('id', $grade);
            });
        })
        ->search(trim($this->search))->loadLatest($this->per_page, $this->orderBy, $this->sortBy, $this->status, $this->gender);
    }

    public function deleteAll()
    {
        ClientStudent::withoutGlobalScope(new HasActiveScope)->whereIn('uuid', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('success', ['message' => 'All selected students
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function activateAll()
    {
        $student = ClientStudent::withoutGlobalScope(new HasActiveScope)->whereIn('uuid', $this->selectedRows)->update([
            'status' => true,
        ]);


        $this->dispatchBrowserEvent('success', ['message' => 'All selected students
            were activated']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function promoteAll()
    {
        $toBePromoted = ClientStudent::withoutGlobalScope(new HasActiveScope)->whereIn('uuid', $this->selectedRows)->get();

        foreach ($toBePromoted as $value) {
            $newGrade = $value->grade_id +1;
            $value->update(['grade_id' => $newGrade]);
        }

        $this->dispatchBrowserEvent('success', ['message' => 'All selected students
            were promoted successfully!']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function repeatAll()
    {
        $toBePromoted = ClientStudent::withoutGlobalScope(new HasActiveScope)->whereIn('uuid', $this->selectedRows)->get();

        foreach ($toBePromoted as $value) {
            $newGrade = $value->grade_id -1;
            $value->update(['grade_id' => $newGrade]);
        }

        $this->dispatchBrowserEvent('success', ['message' => 'All selected students
            were repeated successfully!']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function studentDetails(ClientStudent $student)
    {
        $this->student_details = $student;
        $this->dispatchBrowserEvent('show-details');
    }
    
    public function render()
    {
        return view('livewire.components.admin.student', [
            'students' => $this->students,
            'grades' => Grade::all(),
        ]);
    }
}