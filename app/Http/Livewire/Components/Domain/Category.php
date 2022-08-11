<?php

namespace App\Http\Livewire\Components\Domain;

use Livewire\Component;
use App\Models\PostCategory;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Services\SaveImageService;

class Category extends Component
{

    use WithPagination;
    use WithFileUploads;
    
    public $name = ''; 
    public $image = ''; 
    public $count = 2;

    public function createCategory()
    {
        
        $this->validate([
            'name' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
        ]);

        $category = new PostCategory([
            'name' => $this->name
        ]);
        

        $category->image = $this->image->store('post_categories', 'public');
        $category->save();

        $this->dispatchBrowserEvent('success', [
            'message'     => 'Category created successfully!',
        ]);

        $this->name = '';
        $this->image = '';

    }

    public function resetState()
    {
        $this->name = '';
        $this->image = '';
    }

    public function loadMore()
    {
        $this->count += 2;
    }

    public function getCategoriesProperty()
    {
        return PostCategory::orderBy('created_at','desc')->limit($this->count)->get();
    }
    
    public function render()
    {
        return view('livewire.components.domain.category', [
            'categories' => $this->categories
        ]);
    }
}