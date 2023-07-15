<?php

namespace App\Http\Livewire\Components\Student\Market;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

    public $count = 10;
    public $category = '';
    public $search = '';


    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
    ];

    public function getProductsProperty()
    {
        return Product::when($this->category, function($query, $category) {
            $query->whereHas('category', function($query) use ($category) {
                $query->where('id', $category);
            });
        })->search(trim($this->search))->inRandomOrder()->paginate($this->count); 
    }

    public function setCategory($id)
    {
        $this->category = $id;
    }

    public function clearSearchFilter()
    {
        $this->search = '';
    }

    public function clearCategoryFilter()
    {
        $this->category = '';
    }
    
    public function render()
    {
        return view('livewire.components.student.market.index',[
            'products' => $this->products,
            'categories' => Category::all(),
        ]);
    }
}
