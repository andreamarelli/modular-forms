<?php

namespace AndreaMarelli\ModularForms\View\Components\Accordion;

use Illuminate\View\Component;
use Illuminate\View\View;

class Item extends Component
{
    /**
     * Create the component instance.
     */
    public function __construct(
        public string $title,
        public bool $isInteractive
    ){
        $this->isInteractive = $isInteractive ?: true;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('modular-forms::components.accordion.xxxx');
    }
}
