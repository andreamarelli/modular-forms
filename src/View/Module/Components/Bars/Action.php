<?php

namespace ModularForms\View\Module\Components\Bars;

use ModularForms\Controllers\Controller;
use Illuminate\View\Component;
use Illuminate\View\View;

class Action extends Component{

    public function __construct(
        public string $controller,
        public array $definitions,
        public array $records,
        public ?int $formId,
        public bool $noData,
        public string $mode
    ){}

    public function render(): View|null
    {
        return view('modular-forms::module.components.bars.actions');
    }

}
