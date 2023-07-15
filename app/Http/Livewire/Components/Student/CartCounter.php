<?php

namespace App\Http\Livewire\Components\Student;

use App\Models\Cart;
use Livewire\Component;

class CartCounter extends Component
{

    public $total = 0;
    protected $listeners = ['updateCartCount'  => 'mount']; 

    public function mount()
    {
        $count = Cart::with('course')->where('user_id', auth()->id())->count();
        $this->total =  $count;
    }

    public function render()
    {
        return view('livewire.components.student.cart-counter');
    }
}
