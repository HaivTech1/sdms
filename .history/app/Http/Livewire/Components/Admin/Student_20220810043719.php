<?php

namespace App\Http\Livewire\Components\Admin;

use Livewire\Component;
use App\Models\Student as ClientStudent;
use Livewire\WithPagination;

class Student extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 5;
    public $search = '';
    public $type;
    public $sort

    protected $queryString = [
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
        return ClientStudent::search(trim($this->search))->loadLatest($this->per_page);;
    }

    public function deleteAll()
    {
        ClientStudent::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('alert', ['message' => 'All selected sessions
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }
    
    public function render()
    {
        return view('livewire.components.admin.student', [
            'students' => $this->students,
        ]);
    }
}