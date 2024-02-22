<?php
use AndreaMarelli\ModularForms\View\Module\Container;

?>

@if($has_observations)

    {{-- Keep "observation" field even if not_applicable/not_available --}}
    <div class="module_body" v-if="not_applicable || not_available">

        @component('modular-forms::module.components.field_container', [
                'name' => $observation_field['name'],
                'label' => $observation_field['label'] ?? '',
                'label_width' => $definitions['label_width']
            ])

            {{-- input field --}}
            @include('modular-forms::module.edit..field.module-to-vue', [
                'definitions' => $definitions,
                'field' => $observation_field,
                'vue_record_index' => '0'
            ])

        @endcomponent

    </div>

@endif

