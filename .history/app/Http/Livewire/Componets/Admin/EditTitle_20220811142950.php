<?php

namespace App\Http\Livewire\Componets\Admin;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class EditTitle extends Component
{
    public $modelId;
    public $shortId;
    public $origTitle; // initial model name state
    public $newName; // dirty model name state
    public $isName;

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
        $newName = (string)Str::of($this->newName)->trim()->substr(0, 100); // trim whitespace & more than 100 characters
        $newName = $newName === $this->shortId ? null : $newName; // don't save it as model name it if it's identical to the short_id

        $model->name = $newName ?? null;
        $model->save();

        $this->init($model); // re-initialize the component state with fresh data after saving
    }

    private function init(Model $model)
    {
        $this->origName = $model->name ?: $this->shortId;
        $this->newName = $this->origName;
        $this->isName = $model->name ?? false;
    }
}