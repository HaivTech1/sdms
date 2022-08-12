<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Policies\ResultPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditTitle extends Component
{
    use AuthorizesRequests;
    
    public Model $model;
    public $modelId;
    public $shortId;
    public $origTitle;
    public $newTitle; 
    public $isTitle;
    public string $field;

    public function mount(Model $model)
    {
        $this->modelId = $model->id();
        $this->shortId = $model->short_id;
        $this->origTitle = $model->getAttribute($this->field);
        
        $this->init($model); // initialize the component state
    }

    public function save()
    {
        $mode = class_basename($this->model);
        
        if($mode === 'Result'){
            $this->authorize(ResultPolicy::UPDATE, $this->model);
        }

        $newTitle = (string)Str::of($this->newTitle)->trim()->substr(0, 100);
        $newTitle = $newTitle === $this->shortId ? null : $newTitle;
        $this->model->setAttribute($this->field, $newTitle ?? null)->save();
        $this->init($this->model);

        $this->dispatchBrowserEvent('success', [
            'message'     => "$this->field updated to $newTitle successfully!",
        ]);
    }

    private function init(Model $model)
    {
        $this->origTitle = $model->getAttribute($this->field) ?: $this->shortId;
        $this->newTitle = $this->origTitle;
        $this->isTitle = $model->getAttribute($this->field) ?? false;
    }
    
    public function render()
    {
        return view('livewire.components.edit-title');
    }
}