<?php

namespace App\Http\Livewire\Components\Admin\Commerce\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class Index extends Component
{
    public $selectedRows = [];
    public $selectPageRows = false;
    public $title = '';
    
    use WithPagination;

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->categories->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function createCategory()
    {
        
        $this->validate([
            'title' => 'required|string',
        ]);

        $title = new Category([
            'title' => $this->title
        ]);
        
        $title->save();

        $this->dispatchBrowserEvent('success', [
            'message'     => 'category created successfully!',
        ]);

        $this->title = '';

    }

    public function resetState()
    {
        $this->title = '';
    }

    public function getCategoriesProperty()
    {
        return Category::all();
    }

    public function delete(Category $category)
    {
        $category->delete();
        $this->dispatchBrowserEvent('success', ['message' => 'Category deleted!']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function deleteAll()
    {
        Category::whereIn('uuid', $this->selectedRows)->delete();
        $this->dispatchBrowserEvent('success', ['message' => 'All selected products deleted']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function render()
    {
        return view('livewire.components.admin.commerce.category.index',[
            'categories' => $this->categories
        ]);
    }
}
