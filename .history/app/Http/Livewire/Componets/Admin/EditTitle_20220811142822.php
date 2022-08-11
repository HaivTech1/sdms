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
        $this->modelId = $model->id;
        $this->shortId = $model->short_id;
        $this->origTitle = $model->title;
        
        $this->init($widget); // initialize the component state
    }

    public function render()
    {
        return view('livewire.componets.admin.edit-title');
    }
}