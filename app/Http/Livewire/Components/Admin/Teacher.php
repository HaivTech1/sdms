<?php

namespace App\Http\Livewire\Components\Admin;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;

class Teacher extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 10;
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
        return User::where('type', User::TEACHER)->search(trim($this->search))
        ->load($this->per_page);
    }

    public function deleteAll()
    {
        User::whereIn('id', $this->selectedRows)->delete();
        $this->dispatchBrowserEvent('success', ['message' => 'All selected teachers have been deleted!']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function disableAll()
    {
        User::whereIn('id', $this->selectedRows)->update([
            'isAvailable' => false,
        ]);
        $this->dispatchBrowserEvent('success', ['message' => 'All selected teachers have been disabled!']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function undisableAll()
    {
        User::whereIn('id', $this->selectedRows)->update([
            'isAvailable' => true,
        ]);
        $this->dispatchBrowserEvent('success', ['message' => 'All selected teachers have been activated!']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function render()
    {
        return view('livewire.components.admin.teacher',[
            'teachers' => $this->teachers,
            'grades' => Grade::orderBy('title')->pluck('title', 'id'),
            'allTeachers' => User::where('type', User::TEACHER)->get(),
            'activeTeachers' => User::where('type', User::TEACHER)->where('isAvailable', true)->get(),
            'unactiveTeachers' => User::where('type', User::TEACHER)->where('isAvailable', false)->get(),
            'subjects' => Subject::all()
        ]);
    }
}
