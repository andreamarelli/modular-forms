<?php

namespace AndreaMarelli\ModularForms\View\Button\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;
use Illuminate\View\View;

class DestroyDialog extends Component
{
    public function __construct(
        public string $controller,
        public Model|string $item
    ) {
        $this->controller = $controller;
        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.\
     */
    public function render(): View
    {
        return view('modular-forms::components.button.destroy_form_with_dialog');
    }

}
