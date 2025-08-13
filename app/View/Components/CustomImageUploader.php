<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CustomImageUploader extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     * 
     */
    public $labelCaption;
    public $name;
    public $onchange;
    public $inputData;
    public $defaultImage;
    public function __construct($labelCaption="",$name="",$onchange="",$inputData="",$defaultImage= "")
    {
        $this->labelCaption=$labelCaption;
        $this->name=$name;
        $this->onchange=$onchange;
        $this->inputData=$inputData;
        $this->defaultImage=$defaultImage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.custom-image-uploader');
    }
}
