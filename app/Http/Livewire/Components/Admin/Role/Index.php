<?php

namespace App\Http\Livewire\Components\Admin\Role;

use App\Models\Role;
use Livewire\Component;
use App\Models\Permission;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 20;
    public $state = []; 
    public $title = ''; 
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->roles->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getRolesProperty()
    {
        return Role::search(trim($this->search))->loadLatest($this->per_page);
    }

    public function createRole()
    {
        
        $this->validate([
            'title' => 'required|string',
        ]);

        $title = new Role([
            'title' => $this->title
        ]);
        
        $title->save();

        $this->dispatchBrowserEvent('success', [
            'message'     => 'Role created successfully!',
        ]);

        $this->title = '';

    }

    public function resetState()
    {
        $this->title = '';
    }

    public function deleteAll()
    {
        Role::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('success', ['message' => 'All selected role
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function render()
    {
        return view('livewire.components.admin.role.index',[
            'roles' => $this->roles,
            'permissions' => Permission::all()
        ]);
    }
}