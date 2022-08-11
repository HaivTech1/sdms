<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

class ToggleButton extends Component
{
    public Model $model;
    public string $field;

    public bool $isAvailable;
    

    public function mount()
    {
        $this->isAvailable = (bool) $this->model->getAttribute($this->field);
    }
    
    public function render()
    {
        return view('livewire.components.toggle-button', [
            'model' => $this->model
        ]);
    }

    public function updating($field, $value)
    {
        $this->model->setAttribute($this->field, $value)->save();

        $this->emit('refreshData');

        $this->dispatchBrowserEvent('success', [
            'message'     => 'Status changed successfully, please refresh!',
        ]);
    }
}