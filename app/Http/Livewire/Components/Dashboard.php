<?php

namespace App\Http\Livewire\Components;

use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $users          = User::all();
        return view('livewire.components.dashboard', [
            'users'             => $users,
        ]);
    }
}