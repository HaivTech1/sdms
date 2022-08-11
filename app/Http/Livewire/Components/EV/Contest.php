<?php

namespace App\Http\Livewire\Components\Ev;

use App\Models\Contest as ClientContest;
use Livewire\Component;
use Livewire\WithPagination;

class Contest extends Component
{
    use WithPagination;

    public $per_page = 5; 

    public $listeners = [
        'contestants' => 'refreshData',
    ];

    public function getContestsProperty()
    {
        return ClientContest::paginate($this->per_page);
    }

    public function contestants()
    {
        $this->reset();
      
    }

    public function render()
    {
        return view('livewire.components.ev.contest',[
            'contests' => $this->contests,
        ]);
    }
}