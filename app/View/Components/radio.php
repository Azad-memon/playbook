<?php

namespace App\View\Components;

use Illuminate\View\Component;

class radio extends Component
{
    public $labelCaption;
    public $name;
    public $options;
    public $class;
    public $id;
    public $dataCheck;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name="", $labelCaption="",$options,$class="",$id="",$dataCheck="")
    {
        $this->name=$name;
        $this->labelCaption=$labelCaption;
        $this->options=$options;
        $this->class=$class;
        $this->id=$id;
        $this->dataCheck=$dataCheck;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.radio');
    }
}
