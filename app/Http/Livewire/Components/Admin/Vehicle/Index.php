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
