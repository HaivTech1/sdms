<?php

namespace App\Http\Livewire\Manager;

use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use App\Models\User as ClientUser;
use Illuminate\Support\Facades\Validator;

class User extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 20;
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->users->pluck('id')->map(function ($id) {
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

    public function getUsersProperty()
    {
        return ClientUser::search(trim($this->search))
        ->load($this->per_page);
    }

    public function deleteAll()
    {
        ClientUser::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('success', ['message' => 'All selected users
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }
    

    public function disableAll()
    {
        ClientUser::whereIn('id', $this->selectedRows)->update(['isAvailable' => false]);

        $this->dispatchBrowserEvent('success', ['message' => 'All selected users were marked as verified']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function undisableAll()
    {
        ClientUser::whereIn('id', $this->selectedRows)->update(['isAvailable' => true]);
        
        $this->dispatchBrowserEvent('success', ['message' => 'All selected users
            were marked as unverified']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function changeUser($user, $type)
    {
        Validator::make(['type' => $type], [
            'type'      => [
                'required', 
                Rule::in(ClientUser::SUPERADMIN, ClientUser::ADMIN, ClientUser::TEACHER, ClientUser::STUDENT, ClientUser::BURSAL),
            ],
        ]);
        $use = ClientUser::findOrFail($user['id']);
        $use->update(['type' => $type]);
        $this->dispatchBrowserEvent('success', ['message' => 'User updated successfully!']);
        $this->reset();
    }
    
    public function render()
    {
        return view('livewire.manager.user', [
            'users' => $this->users,
            'roles' => Role::all(),
        ]);
    }
}