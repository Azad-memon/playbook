<?php

namespace App\View\Components;

use Illuminate\View\Component;

class checkbox extends Component
{
    public $labelCaption;
    public $name;
    public $options;
    public $class;
    public $id;
    public $checkboxToCheck;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name="", $labelCaption="",$options,$class="",$id="",$checkboxToCheck="")
    {
        $this->name=$name;
        $this->labelCaption=$labelCaption;
        $this->options=$options;
        $this->class=$class;
        $this->id=$id;
        $this->checkboxToCheck=$checkboxToCheck;
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.checkbox');
    }
}
