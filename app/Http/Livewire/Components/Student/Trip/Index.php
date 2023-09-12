<?php

namespace App\Http\Livewire\Components\Student\Trip;

use App\Models\Trip;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

    public $search = '';
    public $per_page = 10;
    
    public function getTripsProperty()
    {
        return Trip::search(trim($this->search))->load($this->per_page);
    }
    
    public function render()
    {
        return view('livewire.components.student.trip.index',[
            'trips' => $this->trips
        ]);
    }
}