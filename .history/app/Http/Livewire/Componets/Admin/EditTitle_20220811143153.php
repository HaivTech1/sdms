<?php

titlespace App\Http\Livewire\Componets\Admin;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class EditTitle extends Component
{
    public $modelId;
    public $shortId;
    public $origTitle; // initial model title state
    public $newTitle; // dirty model title state
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
        $newTitle = (string)Str::of($this->newTitle)->trim()->substr(0, 100); // trim whitespace & more than 100 characters
        $newTitle = $newTitle === $this->shortId ? null : $newTitle; // don't save it as model title it if it's identical to the short_id

        $model->title = $newTitle ?? null;
        $model->save();

        $this->init($model); // re-initialize the component state with fresh data after saving
    }

    private function init(Model $model)
    {
        $this->origTitle = $model->title ?: $this->shortId;
        $this->newTitle = $this->origTitle;
        $this->isTitle = $model->title ?? false;
    }
}