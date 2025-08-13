<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputField extends Component
{
    public $label;
    public $labelCaption;
    public $id;
    public $type;
    public $name;
    public $placeholder;
    public $error;
    public $inputData;
    public $labelClass;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label="", $labelCaption="",$id="",$type="",$name="",$placeholder="",$error="",$inputData="",$labelClass="")
    {
        $this->label=$label;
        $this->labelCaption=$labelCaption;
        $this->id=$id;
        $this->type=$type;
        $this->placeholder=$placeholder;
        $this->name=$name;
        $this->error=$error;
        $this->inputData=$inputData;
        $this->labelClass=$labelClass;
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input-field');
    }
}
