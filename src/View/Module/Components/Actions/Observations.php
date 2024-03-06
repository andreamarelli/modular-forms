<?php

namespace AndreaMarelli\ModularForms\View\Module\Components\Actions;

use Illuminate\View\Component;
use Illuminate\View\View;

class Observations extends Component
{
    public bool $has_observations;
    public ?array $observation_field;

    public function __construct(public array $definitions)
    {
        // Retrieve the "Observation" field (if exists)
        $this->has_observations = false;
        $this->observation_field = null;
        if($this->definitions['module_type']==='TABLE' || $this->definitions['module_type']==='ACCORDION'){
            foreach($definitions['common_fields'] as $common_field){
                if($common_field['name'] === 'observations'){
                    $this->has_observations = true;
                    $this->observation_field = $common_field;
                }
            }
        } else {
            foreach($this->definitions['fields'] as $field){
                if($field['name'] === 'observations'){
                    $this->has_observations = true;
                    $this->observation_field = $field;
                }
            }
        }
    }

    public function render(): View
    {
        return view('modular-forms::module.components.actions.observations');
    }

}
