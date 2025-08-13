<?php

namespace App\View\Components;

use Illuminate\View\Component;

class button extends Component
{
    public $id; 
    public $name;
    public $buttonClass;
    public $type;
    public $buttonValue;
   
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id="",$name="",$buttonClass="",$type="",$buttonValue="")

    {
        $this->id=$id;
        $this->type=$type;
        $this->buttonClass=$buttonClass;
        $this->name=$name;
        $this->buttonValue=$buttonValue;
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
