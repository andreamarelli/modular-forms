<?php

namespace AndreaMarelli\ModularForms\View\Components\Accordion;

use Illuminate\View\Component;

class Item extends Component
{
    /**
     * Create the component instance.
     */
    public function __construct(
        public string $title =''
    ){}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): string
    {
        return view('modular-forms::components.accordion.item');
    }
}
