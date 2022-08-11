<?php

namespace App\Http\Livewire\Componets\Admin;

use Livewire\Component;

class EditTitle extends Component
{
    public $origName; // initial widget name state

    public function mount(Widget $widget)
    {
        $this->origName = $widget->name;
    }

    public function render()
    {
        return view('livewire.edit-name');
    }
    public function render()
    {
        return view('livewire.componets.admin.edit-title');
    }
}