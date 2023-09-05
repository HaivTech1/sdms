<?php

namespace App\Http\Livewire\Components\Admin\Vehicle;

use App\Models\Vehicle;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->vehicles->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function delete($id)
    {
        Vehicle::where('id', $id)->delete();
        $this->dispatchBrowserEvent('success', ['message' => 'Vehicles has been deleted!']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

     public function deleteAll()
    {
        Vehicle::whereIn('id', $this->selectedRows)->delete();
        $this->dispatchBrowserEvent('success', ['message' => 'All selected vehicles have been deleted!']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function getVehiclesProperty()
    {
        return Vehicle::all();
    }
    
    public function render()
    {
        return view('livewire.components.admin.vehicle.index',[
            'vehicles' => $this->vehicles
        ]);
    }
}