<?php

namespace AndreaMarelli\ModularForms\View\Components\Button;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;
use Illuminate\View\View;

class GenericButton extends Component
{
    /**
     * Create the component instance.
     */
    public function __construct(
        public String $controller,
        public Model|String $item,
        public String|null $action = null,
        public String|null $text = null,
        public bool $newPage = false,
        public String|null $tooltip = null
    ){
        $this->controller = $controller;
        $this->action = $action;
        $this->item = $item;
    }

    public function href(): string
    {
        return $this->item instanceof Model
            ? 'href=' . action([$this->controller, $this->action], [$this->item->getKey()])
            : ':href="\'' . vueAction($this->controller, $this->action, $this->item ?? 'item.id') . '\'"';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('modular-forms::components.button.generic');
    }
}
