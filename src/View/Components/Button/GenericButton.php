<?php

namespace AndreaMarelli\ModularForms\View\Components\Button;

use Illuminate\View\Component;
use Illuminate\View\View;


class GenericButton extends Component
{
    /**
     * Create the component instance.
     */
    public function __construct(
        public String|null $url = null,
        public String|null $text = null,
        public bool $newPage = false,
        public String|null $tooltip = null
    ){
        $this->url = $url;
    }

    public function href(): string
    {
        return 'href=' . $this->url;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('modular-forms::components.button.generic');
    }
}
