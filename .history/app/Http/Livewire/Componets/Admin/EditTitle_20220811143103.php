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
    public $newtitle; // dirty model title state
    public $istitle;

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
        $newtitle = (string)Str::of($this->newtitle)->trim()->substr(0, 100); // trim whitespace & more than 100 characters
        $newtitle = $newtitle === $this->shortId ? null : $newtitle; // don't save it as model title it if it's identical to the short_id

        $model->title = $newtitle ?? null;
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