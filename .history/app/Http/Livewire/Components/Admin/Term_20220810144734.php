<?php

namespace App\Http\Livewire\Components\Admin;

use Livewire\Component;

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
            $this->selectedRows = $this->periods->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getPeriodsProperty()
    {
        return ClientPeriod::search(trim($this->search))->loadLatest($this->per_page);;
    }

    public function createPeriod()
    {
        
        $this->validate([
            'title' => 'required|string',
        ]);

        $title = new ClientPeriod([
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
        ClientPeriod::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('alert', ['message' => 'All selected sessions
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }
    
    public function render()
    {
        return view('livewire.components.admin.term', [
            'periods' => $this->periods,
        ]);
    }
}