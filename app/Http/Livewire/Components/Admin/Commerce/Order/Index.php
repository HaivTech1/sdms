<?php

namespace App\Http\Livewire\Components\Admin\Commerce\Order;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 10;
    public $title = ''; 
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->orders->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getOrdersProperty()
    {
        return Order::query()->whereHas('student', function ($query) {
            $query->whereHas('student', function ($query) {
                $query->where('first_name', 'LIKE', '%' . $this->search . '%')->orWhere('last_name', 'LIKE', '%' . $this->search);
            });
        })->paginate($this->per_page);
    }

    public function deleteAll()
    {
        Order::whereIn('id', $this->selectedRows)->delete();
        $this->dispatchBrowserEvent('success', ['message' => 'All selected enrollments were deleted']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }
    
    public function render()
    {
        return view('livewire.components.admin.commerce.order.index',[
            'orders' => $this->orders
        ]);
    }
}