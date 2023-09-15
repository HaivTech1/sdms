<?php

namespace App\Http\Livewire\Components\Admin\Permission;

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
            $this->selectedRows = $this->permissions->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getPermissionsProperty()
    {
        return Permission::search(trim($this->search))->loadLatest($this->per_page);
    }

    public function createPermission()
    {
        
        $this->validate([
            'title' => 'required|string',
        ]);

        $title = new Permission([
            'title' => $this->title
        ]);
        
        $title->save();

        $this->dispatchBrowserEvent('success', [
            'message'     => 'Permission created successfully!',
        ]);

        $this->title = '';

    }

    public function resetState()
    {
        $this->title = '';
    }

    public function deleteAll()
    {
        Permission::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('success', ['message' => 'All selected permission
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function render()
    {
        return view('livewire.components.admin.permission.index',[
            'permissions' => $this->permissions
        ]);
    }
}