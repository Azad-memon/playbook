<?php

namespace App\View\Components;

use Illuminate\View\Component;

class fileField extends Component
{
    public $labelCaption;
    public $name;
    public $onchange;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($labelCaption="",$name="",$onchange="")
    {
        $this->labelCaption=$labelCaption;
        $this->name=$name;
        $this->onchange=$onchange;
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.file-field');
    }
}
