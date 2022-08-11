<?php

namespace App\Http\Livewire\Components\Admin\Result;

use Livewire\Component;

class Create extends Component
{

    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 5;
    public $search = '';
    public $gender = '';
    public $sortBy = 'asc';
    public $orderBy = 'first_name';

    protected $queryString = [
        'search' => ['except' => ''],
        'gender' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->students->pluck('uuid')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getStudentsProperty()
    {
        return ClientStudent::when($this->gender, function($query, $gender) {
            return $query->where('gender', $gender);
        })->search(trim($this->search))->loadLatest($this->per_page, $this->orderBy, $this->sortBy);
    }

    public function deleteAll()
    {
        ClientStudent::whereIn('uuid', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('alert', ['message' => 'All selected students
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }
    
    public function render()
    {
        return view('livewire.components.admin.result.create');
    }
}