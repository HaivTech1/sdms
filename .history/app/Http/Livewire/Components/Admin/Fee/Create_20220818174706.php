<?php

namespace App\Http\Livewire\Components\Admin\Fee;

use App\Models\Payment;
use Livewire\Component;

class Create extends Component
{

    public function getFeesProperty()
    {
        return Payment::search(trim($this->search))->loadLatest($this->per_page);
    }

    public function render()
    {
        return view('livewire.components.admin.fee.create');
    }
}