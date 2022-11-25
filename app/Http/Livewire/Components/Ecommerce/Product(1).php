<?php

namespace App\Http\Livewire\Components\Ecommerce;

use App\Models\Product as EcommerceProduct;
use Livewire\Component;
use Livewire\WithPagination;

class Product extends Component
{

    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 5;
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->products->pluck('uuid')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getProductsProperty()
    {
        return EcommerceProduct::search(trim($this->search))
        ->loadLatest($this->per_page);
    }

    public function resetSearch()
    {
        $this->search = '';
    }

    public function markAllAsAvailable()
    {
        EcommerceProduct::whereIn('uuid', $this->selectedRows)->update(['isAvailable' => true]);

        $this->dispatchBrowserEvent('alert', ['message' => 'All selected products were marked as accepted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function markAllAsUnavailable()
    {
        EcommerceProduct::whereIn('uuid', $this->selectedRows)->update(['isAvailable' => false]);
        
        $this->dispatchBrowserEvent('alert', ['message' => 'All selected products
            were marked as rejectted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function deleteAll()
    {
        EcommerceProduct::whereIn('uuid', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('alert', ['message' => 'All selected products
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }
    

    public function markAllAsVerified()
    {
        EcommerceProduct::whereIn('uuid', $this->selectedRows)->update(['isVerified' => true]);

        $this->dispatchBrowserEvent('alert', ['message' => 'All selected products were marked as verified']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function markAllAsUnverified()
    {
        EcommerceProduct::whereIn('uuid', $this->selectedRows)->update(['isVerified' => false]);
        
        $this->dispatchBrowserEvent('alert', ['message' => 'All selected products
            were marked as unverified']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }
    
    public function render()
    {
        return view('livewire.components.ecommerce.product',[
            'products' => $this->products,
        ]);
    }
}