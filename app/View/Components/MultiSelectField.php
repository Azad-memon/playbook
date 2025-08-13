<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MultiSelectField extends Component
{
    public $label;
    public $labelCaption;
    public $id; 
    public $name;
    public $options;
    public $defaultOption;
    public $className;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label="", $labelCaption="",$id="",$name="",$options="",$defaultOption="",$className="")
    {
        $this->label=$label;
        $this->labelCaption=$labelCaption;
        $this->id=$id;
        $this->options=$options;
        $this->defaultOption=$defaultOption;
        $this->name=$name;
        $this->className=$className;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.multi-select-field');
    }
}
