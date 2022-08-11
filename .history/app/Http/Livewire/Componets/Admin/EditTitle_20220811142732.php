<?php

namespace App\Http\Livewire\Componets\Admin;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

class EditTitle extends Component
{
    public $modelId;
    public $shortId;
    public $origTitle; // initial widget name state
    public $newName; // dirty widget name state
    public $isName;

    public function mount(Model $model)
    {
        $this->widgetId = $widget->id;
        $this->shortId = $widget->short_id;
        $this->origTitle = $model->title;
    }

    public function render()
    {
        return view('livewire.componets.admin.edit-title');
    }
}