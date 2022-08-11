<?php

namespace App\Http\Livewire\Components\Admin\Result;

use App\Models\Result;
use Livewire\Component;

class Create extends Component
{

    public $period_id = '';
    public $term_id = '';
    public $grade_id = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'gender' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->results->pluck('uuid')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getResultsProperty()
    {
        return Result::when($this->gender, function($query, $gender) {
            return $query->where('gender', $gender);
        })->search(trim($this->search))->loadLatest($this->per_page, $this->orderBy, $this->sortBy);
    }

    public function deleteAll()
    {
        Result::whereIn('uuid', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('alert', ['message' => 'All selected results
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }
    

    public function render()
    {
        return view('livewire.components.admin.result.create');
    }
}