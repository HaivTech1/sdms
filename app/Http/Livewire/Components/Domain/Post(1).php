<?php

namespace App\Http\Livewire\Components\Domain;

use App\Models\Post as ClientPost;
use Livewire\Component;
use Livewire\WithPagination;

class Post extends Component
{

    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 5;
    public $search = '';
    public $type = '';
    public $category = '';

    protected $queryString = [
        'type' => ['except' => '' ],
        'search' => ['except' => ''],
        'category' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->posts->pluck('uuid')->map(function ($id) {
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

    public function resetFilter()
    {
        $this->reset();
    }

    public function resetSearch()
    {
        $this->search = '';
    }

    public function getPostsProperty()
    {
        return ClientPost::when($this->type, function($query, $type) {
            return $query->where('type', $type);
        })
        ->search(trim($this->search))
        ->loadLatest($this->per_page);
    }

    public function markAllAsAvailable()
    {
        ClientPost::whereIn('uuid', $this->selectedRows)->update(['isAvailable' => true]);

        $this->dispatchBrowserEvent('alert', ['message' => 'All selected posts were marked as accepted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function markAllAsUnavailable()
    {
        ClientPost::whereIn('uuid', $this->selectedRows)->update(['isAvailable' => false]);
        
        $this->dispatchBrowserEvent('alert', ['message' => 'All selected posts
            were marked as rejectted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function deleteAll()
    {
        ClientPost::whereIn('uuid', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('alert', ['message' => 'All selected posts
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }
    

    public function markAllAsVerified()
    {
        ClientPost::whereIn('uuid', $this->selectedRows)->update(['isVerified' => true]);

        $this->dispatchBrowserEvent('alert', ['message' => 'All selected posts were marked as verified']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function markAllAsUnverified()
    {
        ClientPost::whereIn('uuid', $this->selectedRows)->update(['isVerified' => false]);
        
        $this->dispatchBrowserEvent('alert', ['message' => 'All selected posts
            were marked as unverified']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }
    
    public function render()
    {
        $types = ['standard' => 'standard', 'premium' => 'premium'];
        return view('livewire.components.domain.post',[
            'posts' => $this->posts,
            'types' => $types
        ]);
    }
}