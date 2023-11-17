<?php

namespace AndreaMarelli\ModularForms\View\Components\Button\Form;

use AndreaMarelli\ModularForms\Helpers\Template;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Edit extends _Base
{

    public function __construct(string $controller, Model|string $item)
    {
        parent::__construct($controller, $item);
        $this->action = 'edit';
        $this->text = Template::icon('pen', 'white');
        $this->tooltip = Str::ucfirst((trans('modular-forms::common.edit')));
    }

}
