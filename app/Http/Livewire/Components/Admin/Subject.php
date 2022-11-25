<?php

namespace App\Http\Livewire\Components\Admin;

use Livewire\Component;
use App\Models\Subject as ClientSubject;
use App\Models\Grade;
use Livewire\WithPagination;

class Subject extends Component
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
            $this->selectedRows = $this->subjects->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function createSubject()
    {
        
        $this->validate([
            'title' => 'required|string',
        ]);

        $title = new ClientSubject([
            'title' => $this->title
        ]);
        
        $title->save();

        $this->dispatchBrowserEvent('success', [
            'message'     => 'Subject created successfully!',
        ]);

        $this->title = '';

    }

    public function resetTitle()
    {
        $this->title = '';
    }

    public function getsubjectsProperty()
    {
        return ClientSubject::search(trim($this->search))->loadLatest($this->per_page);;
    }

    public function deleteAll()
    {
        ClientSubject::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('alert', ['message' => 'All selected sessions
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }
    
    public function render()
    {
        return view('livewire.components.admin.subject', [
            'subjects' => $this->subjects,
            'grades' => Grade::all()
        ]);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }
}