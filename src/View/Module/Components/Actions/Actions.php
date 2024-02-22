<?php

namespace AndreaMarelli\ModularForms\View\Module\Components\Actions;

use Illuminate\View\Component;
use Illuminate\View\View;

class Actions extends Component{

    public array $definitions;

    public function __construct($definitions)
    {
        $this->definitions = $definitions;
    }

    public function render(): View
    {
        return view('modular-forms::module.components.actions.actions');
    }

}
