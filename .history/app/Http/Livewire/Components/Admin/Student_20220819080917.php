<?php

namespace App\Http\Livewire\Components\Admin;

use App\Models\Grade;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Student as ClientStudent;
use LivewireUI\Spotlight\SpotlightCommand;

class Student extends Component, SpotlightCommand
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 5;
    public $search = '';
    public $gender = '';
    public $sortBy = 'asc';
    public $orderBy = 'first_name';
    public $grade = '';
    public $student_details;
    public $subjects = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'gender' => ['except' => ''],
        'grade' => ['except' => ''],
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
        return ClientStudent::when($this->grade, function($query, $grade) {
            $query->whereHas('grade', function($query) use ($grade){
               $query->where('id', $grade);
            })
            ->when($this->gender, function($query, $gender) {
                return $query->where('gender', $gender);
            });
        })
        ->search(trim($this->search))->loadLatest($this->per_page, $this->orderBy, $this->sortBy);
    }

    public function deleteAll()
    {
        ClientStudent::whereIn('uuid', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('alert', ['message' => 'All selected students
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function studentDetails(ClientStudent $student)
    {
        $this->student_details = $student;
        $this->subjects = Subject::all();
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