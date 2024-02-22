<?php

namespace AndreaMarelli\ModularForms\View\Button\Form;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

abstract class _Button extends Component
{
    protected string $action;
    public string $text;
    public string $tooltip;
    public bool $newPage = false;
    public string $role = 'button';

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
    public function render(): Closure
    {
        return function (array $data)
        {
            $merged_attributes = $data['attributes']->merge(['class' => 'small']);
            $this->attributes->setAttributes([
                'class' => $merged_attributes['class']
            ]);
            return view('modular-forms::components.button.generic');
        };
    }

}
