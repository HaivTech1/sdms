<?php

namespace App\Http\Livewire\Components\Admin\Trip;

use App\Models\Trip;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
     use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $search = '';
    public $per_page = 10;

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->trips->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function delete($id)
    {
        Trip::where('id', $id)->delete();
        $this->dispatchBrowserEvent('success', ['message' => 'Trip has been deleted!']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

     public function deleteAll()
    {
        Trip::whereIn('id', $this->selectedRows)->delete();
        $this->dispatchBrowserEvent('success', ['message' => 'All selected trips have been deleted!']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function getTripsProperty()
    {
        return Trip::search(trim($this->search))->load($this->per_page);
    }
    

    public function render()
    {
        return view('livewire.components.admin.trip.index',[
            'trips' => $this->trips
        ]);
    }
}