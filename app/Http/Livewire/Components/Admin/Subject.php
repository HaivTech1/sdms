<?php

namespace App\Http\Livewire\Components\Admin;

use App\Models\Grade;
use Livewire\Component;
use Livewire\WithPagination;
use App\Scopes\HasActiveScope;
use App\Models\Subject as ClientSubject;

class Subject extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 10;
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
        return ClientSubject::withoutGlobalScope(new HasActiveScope)->search(trim($this->search))->loadLatest($this->per_page);;
    }

    public function deleteAll()
    {
        ClientSubject::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('success', ['message' => 'All selected subjects
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function activateAll()
    {
        ClientSubject::whereIn('id', $this->selectedRows)->update(['status' => 1]);

        $this->dispatchBrowserEvent('success', ['message' => 'All selected subjects
            were activated successfully']);

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