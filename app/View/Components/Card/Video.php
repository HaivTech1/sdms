<?php

namespace App\View\Components\Card;

use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Model;

class Video extends Component
{
    public $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card.video',[
            'model' => $this->model,
        ]);
    }
}
