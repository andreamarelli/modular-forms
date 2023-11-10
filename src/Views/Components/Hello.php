<?php

namespace AndreaMarelli\ModularForms\Views\Components;

use Illuminate\View\Component;

class Hello extends Component
{
    /**
     * Create the component instance.
     */
    public function __construct() {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): string
    {
        return 'Hello';
    }
}
