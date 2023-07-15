<?php

namespace App\Http\Livewire\Components\Student;

use Livewire\Component;
use App\Models\Cart as CartItem;

class Checkout extends Component
{

    public $sub_total = 0;
    public $total = 0;
    public $tax;
    
    public function mount()
    {
        $this->tax = application('tax') ?? 0;

        foreach ($this->cartItems as $cart) {
            $this->sub_total += $cart->product->price() * $cart->quantity;
        }

        $this->total = $this->sub_total + $this->tax;
    }

    public function getCartItemsProperty()
    {
        return CartItem::where('user_id', auth()->id())->get();
    }

    public function render()
    {
        return view('livewire.components.student.checkout',[
            'cartItems' => $this->cartItems
        ]);
    }
}
