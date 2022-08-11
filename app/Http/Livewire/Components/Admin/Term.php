<?php

namespace App\Http\Livewire\Components\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Term as ClientTerm;


class Term extends Component
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
            $this->selectedRows = $this->terms->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function gettermsProperty()
    {
        return ClientTerm::search(trim($this->search))->loadLatest($this->per_page);;
    }

    public function createTerm()
    {
        
        $this->validate([
            'title' => 'required|string',
        ]);

        $title = new ClientTerm([
            'title' => $this->title
        ]);
        
        $title->save();

        $this->dispatchBrowserEvent('success', [
            'message'     => 'Term created successfully!',
        ]);

        $this->title = '';

    }

    public function resetState()
    {
        $this->title = '';
    }

    public function deleteAll()
    {
        ClientTerm::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('alert', ['message' => 'All selected sessions
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }
    
    public function render()
    {
        return view('livewire.components.admin.term', [
            'terms' => $this->terms,
        ]);
    }
}