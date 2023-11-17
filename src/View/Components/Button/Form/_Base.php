<?php

namespace AndreaMarelli\ModularForms\View\Components\Button\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;
use Illuminate\View\View;

abstract class _Base extends Component
{
    protected string $action;
    public string $text;
    public string $tooltip;
    public bool $newPage = false;

    public function __construct(
        public String $controller,
        public Model|String $item
    ) {
        $this->controller = $controller;
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
