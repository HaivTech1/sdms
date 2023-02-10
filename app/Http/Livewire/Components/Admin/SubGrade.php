<?php

namespace App\Http\Livewire\Components\Admin;

use App\Models\Grade;
use Livewire\Component;
use Livewire\WithPagination;
use App\Scopes\HasActiveScope;
use App\Models\SubGrade as ClientSubGrade;

class SubGrade extends Component
{

    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 5;
    public $title = ''; 
    public $grade_id = ''; 
    public $subgrade_details;

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

    public function getSubGradesProperty()
    {
        return ClientSubGrade::withoutGlobalScope(new HasActiveScope)->search(trim($this->search))->loadLatest($this->per_page);
    }

    public function createSubGrade()
    {
        
        $this->validate([
            'title' => 'required|string',
            'grade_id' => 'required|Integer',
        ]);

        $grade = new ClientSubGrade([
            'title' => $this->title,
            'grade_id' => $this->grade_id,
            'status' => true,
        ]);
        
        $grade->save();

        $this->dispatchBrowserEvent('success', [
            'message'     => 'Grade created successfully!',
        ]);

        $this->resetState();

    }

    public function resetState()
    {
        $this->title = '';
        $this->grade_id = '';
    }

    public function deleteAll()
    {
        ClientSubGrade::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('alert', ['message' => 'All selected classes
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function GradeDetails(ClientSubGrade $grade)
    {
        $this->subgrade_details = $grade;
        // dd($this->grade_details);
        $this->dispatchBrowserEvent('show-details');
    }

    public function render()
    {
        return view('livewire.components.admin.sub-grade', [
            'subgrades' => $this->subgrades,
            'grades' => Grade::all(),
        ]);
    }
}
