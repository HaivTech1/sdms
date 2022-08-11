<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class EditTitle extends Component
{
    public Model $model;
    public $modelId;
    public $shortId;
    public $origTitle;
    public $newTitle; 
    public $isTitle;

    public function mount(Model $model)
    {
        $this->modelId = $model->id;
        $this->shortId = $model->short_id;
        $this->origTitle = $model->title;
        
        $this->init($model); // initialize the component state
    }

    public function save()
    {
        dd($this->model);
    }

    private function init(Model $model)
    {
        $this->origTitle = $model->title ?: $this->shortId;
        $this->newTitle = $this->origTitle;
        $this->isTitle = $model->title ?? false;
    }
    
    public function render()
    {
        return view('livewire.components.edit-title');
    }
}