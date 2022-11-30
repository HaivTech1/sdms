<?php

namespace App\Http\Livewire\Components\Admin;

use App\Models\House as HouseDetails;
use Livewire\Component;
use Livewire\WithPagination;

class House extends Component
{
    use WithPagination;

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
            $this->selectedRows = $this->houses->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getHousesProperty()
    {
        return HouseDetails::search(trim($this->search))->loadLatest($this->per_page);
    }

    public function createHouse()
    {
        
        $this->validate([
            'title' => 'required|string',
        ]);

        $title = new HouseDetails([
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
        HouseDetails::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('success', ['message' => 'All selected Houses
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function render()
    {
        return view('livewire.components.admin.house', [
            'houses' => $this->houses,
        ]);
    }
}
