<?php

namespace AndreaMarelli\ModularForms\Views\Components\Accordion;

use Illuminate\View\Component;

use function Termwind\render;

class Accordion extends Component
{
    /**
     * Create the component instance.
     */
    public function __construct(
        public string $class = ''
    ){}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): string
    {
        return <<<'blade'
            <div class="accordion {{ $class }}">
                {{ $slot }}
            </div>
        blade;
    }
}
