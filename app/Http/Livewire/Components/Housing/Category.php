<?php

namespace App\Http\Livewire\Components\Housing;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PropertyCategory;
use Illuminate\Support\Facades\Validator;

class Category extends Component
{

    use WithPagination;

    public $name = ''; 
    public $count = 3;

    public function createCategory()
    {

        $this->validate([
            'name' => 'required|string',
        ]);

        PropertyCategory::create([
            'name' => $this->name
        ]);

        $this->dispatchBrowserEvent('success', [
            'message'     => 'Category created successfully!',
        ]);

        $this->name = '';

    }

    public function resetState()
    {
        $this->name = '';
    }

    public function loadMore()
    {
        $this->count += 2;
    }

    public function getCategoriesProperty()
    {
        return PropertyCategory::orderBy('created_at','desc')->limit($this->count)->get();
    }
    
    public function render()
    {
        return view('livewire.components.housing.category', [
            'categories' => $this->categories
        ]);
    }
}