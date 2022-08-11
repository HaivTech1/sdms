<?php

namespace App\Http\Livewire\Components\EV;

use Livewire\Component;
use App\Models\Contestant as ClientContestant;
use Livewire\WithPagination;

class Contestant extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 5;
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->contestants->pluck('uuid')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getContestantsProperty()
    {
        return ClientContestant::search(trim($this->search))
        ->loadLatest($this->per_page);
    }

    
    public function render()
    {
        return view('livewire.components.e-v.contestant', [
            'contestants' => $this->contestants,
        ]);
    }
}