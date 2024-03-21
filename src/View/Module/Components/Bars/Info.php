<?php

namespace AndreaMarelli\ModularForms\View\Module\Components\Bars;

use Illuminate\View\Component;
use Illuminate\View\View;

class Info extends Component{

    public function __construct(
        array $definitions
    ){}

    public function render(): View
    {
        return view('modular-forms::module.components.bars.info');
    }

}
