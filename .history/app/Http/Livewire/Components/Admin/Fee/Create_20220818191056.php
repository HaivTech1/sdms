<?php

namespace App\Http\Livewire\Components\Admin\Fee;

use App\Models\Payment;
use Livewire\Component;

class Create extends Component
{
    use WithPagination;

    public $count; 
    
    public function getFeesProperty()
    {
        return Payment::loadLatest($this->count);
    }

    public function render()
    {
        return view('livewire.components.admin.fee.create');
    }
}