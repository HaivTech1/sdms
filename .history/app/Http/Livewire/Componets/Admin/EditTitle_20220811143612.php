<?php

namespace App\Http\Livewire\Componets\Admin;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class EditTitle extends Component
{
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

    public function render()
    {
        return view('livewire.componets.admin.edit-title');
    }

    public function save()
    {
        $model = Model::findOrFail($this->modelId);
        $newTitle = (string)Str::of($this->newTitle)->trim()->substr(0, 100);
        $newTitle = $newTitle === $this->shortId ? null : $newTitle;

        $model->title = $newTitle ?? null;
        $model->save();

        $this->init($model);
    }

    private function init(Model $model)
    {
        $this->origTitle = $model->title ?: $this->shortId;
        $this->newTitle = $this->origTitle;
        $this->isTitle = $model->title ?? false;
    }
}