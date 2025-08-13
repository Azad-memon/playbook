<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Timepicker extends Component
{
    public $name;
    public $value;
    public $labelCaption;

    public function __construct($name, $value = null, $labelCaption = 'Select Time')
    {
        $this->name = $name;
        $this->value = $value;
        $this->labelCaption = $labelCaption;
    }

    public function render()
    {
        return view('components.timepicker');
    }
}
