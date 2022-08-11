<?php

namespace App\Http\Livewire\Components\Admin;

use Livewire\Component;
use App\Models\Period as ClientPeriod;
use Livewire\WithPagination;

class Student extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 5;
    public $title = ''; 

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->students->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getstudentsProperty()
    {
        return ClientStudent::search(trim($this->search))->loadLatest($this->per_page);;
    }

    public function createPeriod()
    {
        
        $this->validate([
            'title' => 'required|string',
        ]);

        $title = new ClientStudent([
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