<?php

namespace App\Http\Livewire\Components\Admin\Fee;

use App\Models\Fee;
use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use Livewire\Component;
use Livewire\WithPagination;
use App\Scopes\HasActiveScope;

class Index extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 5;
    public $state = []; 

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->fees->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getFeesProperty()
    {
        return Fee::withoutGlobalScope(new HasActiveScope)->search(trim($this->search))->loadLatest($this->per_page);
    }

    public function resetState()
    {
        $this->title = '';
    }

    public function deleteAll()
    {
        Fee::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('alert', ['message' => 'All selected fees
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }
    
    public function render()
    {
        return view('livewire.components.admin.fee.index', [
            'fees' => $this->fees,
            'grades' => Grade::all(),
            'terms' => Term::all(),
            'periods' => Period::all(),
        ]);
    }
}