<?php

namespace AndreaMarelli\ModularForms\View\Components\Button\Form;

use AndreaMarelli\ModularForms\Helpers\Template;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Destroy extends Component
{
    private string $action = 'destroy';
    public string $form_method = 'post';
    public string $hidden_inputs = '';
    public string $role = 'submit';
    public string $tooltip;

    public function __construct(
        public string $controller,
        public Model|string $item,
        public string|null $text = null
    ) {
        $this->controller = $controller;
        $this->item = $item;
        $this->text = $text ?? Template::icon('trash', 'white');
        $this->tooltip = Str::ucfirst((trans('modular-forms::common.delete')));
        $this->hidden_inputs =
            '<input name="_method" type="hidden" value="DELETE">';
    }


    public function form_action(): string
    {
        if($this->item instanceof Model){
           return 'action='.action([$this->controller, $this->action], [$this->item->getKey()]);
        }  else if(is_int($this->item)){
            return 'action='.action([$this->controller, $this->action], [$this->item]);
        } else {
            return ':action="\'' . vueAction($this->controller, $this->action, $this->item ?? 'item.id') . '\'"';
        }
    }

    /**
     * Get the view / contents that represent the component.\
     */
    public function render(): Closure
    {
        return function (array $data)
        {
            $merged_attributes = $data['attributes']->merge(['class' => 'red']);
            $this->attributes->setAttributes([
                'class' => $merged_attributes['class']
            ]);
            return view('modular-forms::components.button.with_form');
        };
    }

}
