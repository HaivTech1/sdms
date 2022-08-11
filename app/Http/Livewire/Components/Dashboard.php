<?php

namespace App\Http\Livewire\Components;

use App\Models\Post;
use App\Models\User;
use App\Models\Booking;
use App\Models\Product;
use Livewire\Component;
use App\Models\Property;

class Dashboard extends Component
{
    public function render()
    {
        $users          = User::all();
        $properties     = Property::all();
        $bookings       = Booking::all();
        $posts          = Post::all();
        $products       = Product::all();
        return view('livewire.components.dashboard', [
            'properties'        => $properties,
            'bookings'          => $bookings,
            'users'             => $users,
            'posts'             => $posts,
            'products'          => $products
        ]);
    }
}