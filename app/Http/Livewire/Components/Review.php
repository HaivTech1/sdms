<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

class Review extends Component
{
    public $model;
    
    public function mount(Model $model)
    {
        $this->model = $model;
    }
    
    public function render()
    {
        $reviews = $model->reviews;
        
        return view('livewire.components.review',[
            'reviews' => $reviews
        ]);
    }
}