<?php

namespace App\Http\Livewire\Manager;

use App\Models\Pincode;
use Livewire\Component;
use Livewire\WithPagination;

class Generate extends Component
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
            $this->selectedRows = $this->pins->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function loadMore()
    {
        $this->count += 4;
    }

    public function resetSearch()
    {
        $this->search = '';
    }

    public function getPinsProperty()
    {
        return Pincode::load($this->per_page);
    }

   
    public function render()
    {
        return view('livewire.manager.generate',[
            'pins' => $this->pins,
        ]);
    }
}