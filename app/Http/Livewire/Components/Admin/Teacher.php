<?php

namespace App\Http\Livewire\Components\Admin;

use App\Models\User;
use App\Models\Grade;
use Livewire\Component;
use Livewire\WithPagination;

class Teacher extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 5;
    public $search = '';
    public $user_id;
    public $grade_id;



    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->teachers->pluck('id')->map(function ($id) {
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

    public function getTeachersProperty()
    {
        return User::where('type', 3)->search(trim($this->search))
        ->load($this->per_page);
    }

    public function assignClasses()
    {
        dd($this->grade_id, $this->user_id);
    }

    public function render()
    {
        return view('livewire.components.admin.teacher',[
            'teachers' => $this->teachers,
            'grades' => Grade::orderBy('title')->pluck('title', 'id')
        ]);
    }
}
