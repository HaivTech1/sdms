<?php

namespace App\Http\Livewire\Components\Admin\Staff;

use App\Models\User;
use App\Models\Grade;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $count = 10;
    public $search = '';
    public $user_id;
    public $type;



    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->employees->pluck('id')->map(function ($id) {
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

    public function getEmployeesProperty()
    {
        return User::when($this->type, function($query, $type) {
            $query->where('type', $type);
        })->whereNotIn('type', [1, 4])->search(trim($this->search))
        ->load($this->count);
    }

    public function deleteAll()
    {
        $users = User::whereIn('id', $this->selectedRows)->get();

        foreach ($users as $value) {
            $profile = Profile::where('author_id', $value->id())->delete();
            $value->delete();
        }

        $this->dispatchBrowserEvent('success', ['message' => 'All selected employees were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }
    

    
    public function render()
    {

        $ids = Grade::getAllIdsExceptLast();
        $grades = Grade::gradeIds($ids)->pluck('title', 'id');

        return view('livewire.components.admin.staff.index',[
            'employees' => $this->employees,
            'grades' => $grades
        ]);
    }
}
