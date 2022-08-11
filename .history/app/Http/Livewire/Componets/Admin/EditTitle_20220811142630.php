<?php

namespace App\Http\Livewire\Componets\Admin;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

class EditTitle extends Component
{
    public $widgetId;
    public $shortId;
    public $origTitle; // initial widget name state

    public function mount(Model $model)
    {
        $this->origTitle = $model->title;
    }

    public function render()
    {
        return view('livewire.componets.admin.edit-title');
    }
}