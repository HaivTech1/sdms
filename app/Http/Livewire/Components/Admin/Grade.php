<?php

namespace App\Http\Livewire\Components\Admin;

use Livewire\Component;
use App\Models\Grade as ClientGrade;
use Livewire\WithPagination;

class Grade extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 5;
    public $title = ''; 
    public $grade_details;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->grades->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getGradesProperty()
    {
        return ClientGrade::search(trim($this->search))->loadLatest($this->per_page);
    }

    public function createGrade()
    {
        
        $this->validate([
            'title' => 'required|string',
        ]);

        $title = new ClientGrade([
            'title' => $this->title
        ]);
        
        $title->save();

        $this->dispatchBrowserEvent('success', [
            'message'     => 'Period created successfully!',
        ]);

        $this->title = '';

    }

    public function resetState()
    {
        $this->title = '';
    }

    public function deleteAll()
    {
        ClientGrade::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('alert', ['message' => 'All selected classes
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function GradeDetails(ClientGrade $grade)
    {
        $this->grade_details = $grade;
        // dd($this->grade_details);
        $this->dispatchBrowserEvent('show-details');
    }
    
    public function render()
    {
        return view('livewire.components.admin.grade', [
            'grades' => $this->grades,
        ]);
    }
}