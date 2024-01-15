<?php

namespace AndreaMarelli\ModularForms\View\Module\Components;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;

class Script extends Component{

    public function __construct(
        public Collection $collection,
        public array $vueData,
        public array $definitions
    ){}

    public function render(): View
    {
        return view('modular-forms::module.edit..script');
    }

}
