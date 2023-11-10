<?php

namespace AndreaMarelli\ModularForms\Views\Components\Accordion;

use Illuminate\View\Component;

class Item extends Component
{
    /**
     * Create the component instance.
     */
    public function __construct(
        public string $title
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): string
    {
        return <<<'blade'
            <div class="accordion-item">

                <div class="accordion-item-header">
                    <div class="accordion-item-header-title" onclick="window.ModularForms.Mixins.Accordion.toggle(event)">
                        {{ $title }}
                    </div>
                </div>

                <div class="accordion-item-body">
                    <div class="accordion-item-body-content">
                        {{ $slot }}
                    </div>
                </div>

            </div>
        blade;
    }
}
