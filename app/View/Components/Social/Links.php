<?php

namespace App\View\Components\Social;

use Illuminate\View\Component;

class Links extends Component
{
    public $application;
    public $url;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($application, $url)
    {
        $this->application = $application;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.social.links');
    }
}
