<?php

namespace App\Http\Livewire\Components\Student;

use App\Models\Cart;
use App\Models\Product;
use Livewire\Component;

class AddToCart extends Component
{
    public $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function addToCart($productId)
    {
        try {
            $data = [
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'quantity'      => 1,
                'price' => $this->product->price
            ];
            Cart::updateOrCreate($data);
            $this->emit('updateCartCount');
            $this->dispatchBrowserEvent('success', ['message' => 'Product added to cart successfully!']);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('error', ['message' => ''.$th->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.components.student.add-to-cart');
    }
}
