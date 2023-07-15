<?php

namespace App\Http\Livewire\Components\Admin\Commerce;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use App\Scopes\HasActiveScope;
use Illuminate\Support\Facades\File;

class Index extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 5;
    public $orderBy = 'title';
    public $sortBy = 'asc';
    public $category = '';
    public $status = '';

    protected $queryString = [
        'category' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->products->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getProductsProperty()
    {
        return Product::withoutGlobalScope(new HasActiveScope)->when($this->category, function($query, $category) {
            $query->whereHas('category', function($query) use ($category) {
                $query->where('id', $category);
            });
        })->loadLatest($this->per_page, $this->orderBy, $this->sortBy, $this->status);
    }

    public function delete(Product $product)
    {
        File::delete(storage_path('app/public/'.$product->image));
        $product->delete();
        $this->dispatchBrowserEvent('success', ['message' => 'Product deleted!']);
        $this->reset(['reset']);
    }

    public function deleteAll()
    {
        Product::withoutGlobalScope(new HasActiveScope)->whereIn('id', $this->selectedRows)->delete();
        $this->dispatchBrowserEvent('success', ['message' => 'All selected products deleted']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function activateAll()
    {
        $student = Product::withoutGlobalScope(new HasActiveScope)->whereIn('id', $this->selectedRows)->update([ 'status' => true ]);
        $this->dispatchBrowserEvent('success', ['message' => 'All selected products were activated']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }
    
    public function render()
    {
        $activeProducts = Product::where('status', true)->count();
        $inactiveProducts = Product::where('status', false)->count();

        return view('livewire.components.admin.commerce.index',[
            'products' => $this->products,
            'activeProducts' => $activeProducts,
            'inactiveProducts' => $inactiveProducts,
            'categories' => Category::all()
        ]);
    }
}
