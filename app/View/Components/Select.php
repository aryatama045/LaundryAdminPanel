<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public $name, $multi;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $multi = false)
    {
        $this->name = $name;
        $this->multi = $multi;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select');
    }
}
