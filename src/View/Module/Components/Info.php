<?php

namespace AndreaMarelli\ModularForms\View\Module\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Info extends Component{

    public array $definitions;

    public function __construct(array $definitions)
    {
        $this->definitions = $definitions;
    }

    public function render(): View
    {
        return view('modular-forms::module.components.info');
    }

}
