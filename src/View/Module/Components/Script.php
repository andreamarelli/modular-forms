<?php

namespace AndreaMarelli\ModularForms\View\Module\Components;

use AndreaMarelli\ModularForms\View\Module\Container;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;

class Script extends Component{

    public function __construct(
        public Collection $collection,
        public array $vueData,
        public array $definitions,
        public string $mode
    ){}

    public function render(): View
    {
        if($this->mode === Container::MODE_EDIT){
            return view('modular-forms::module.edit.script');
        } else{
            return view('modular-forms::module.show.script');
        }

    }

}
