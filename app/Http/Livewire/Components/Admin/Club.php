<?php

namespace App\Http\Livewire\Components\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Scopes\HasActiveScope;
use App\Models\Club as ClubDetails;


class Club extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 5;
    public $state = []; 
    public $title = ''; 
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->clubs->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getClubsProperty()
    {
        return ClubDetails::withoutGlobalScope(new HasActiveScope)->search(trim($this->search))->loadLatest($this->per_page);
    }

    public function createClub()
    {
        
        $this->validate([
            'title' => 'required|string',
        ]);

        $title = new ClubDetails([
            'title' => $this->title
        ]);
        
        $title->save();

        $this->dispatchBrowserEvent('success', [
            'message'     => 'House created successfully!',
        ]);

        $this->title = '';

    }

    public function resetState()
    {
        $this->title = '';
    }

    public function deleteAll()
    {
        ClubDetails::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('success', ['message' => 'All selected clubs
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }
    
    public function render()
    {
        return view('livewire.components.admin.club', [
            'clubs' => $this->clubs,
        ]);
    }
}
