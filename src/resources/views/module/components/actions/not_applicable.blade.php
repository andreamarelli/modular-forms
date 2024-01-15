<?php
use AndreaMarelli\ModularForms\View\Module\Container;

?>

@if($definitions['enable_not_applicable'])

    {{-- #### Not applicable #### --}}
    <div id="applicable-{{ $definitions['module_key'] }}"
         v-if=!not_available
         style="display: inline-block; margin-right: 30px;">
        <label for="not_applicable">@lang('modular-forms::common.form.applicable')</label>
        <input type="checkbox"
               :checked=not_applicable
               v-on:change="toggleNotApplicable()"
        />
        <tooltip>
            @uclang('modular-forms::common.form.applicable_tooltip')
        </tooltip>
    </div>

    {{-- #### Not avalibale #### --}}
    <div id="available-{{ $definitions['module_key'] }}"
         v-if=!not_applicable
         style="display: inline-block; margin-right: 30px;">
        <label for="not_available">@lang('modular-forms::common.form.not_available')</label>
        <input type="checkbox"
               :checked=not_available
               v-on:change="toggleNotAvailable()"
        />
        <tooltip>
            @uclang('modular-forms::common.form.available_tooltip')
        </tooltip>
    </div>

@endif

