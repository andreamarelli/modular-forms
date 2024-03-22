<?php

use AndreaMarelli\ModularForms\View\Module\Container;
use Illuminate\Support\Facades\Blade;

?>

<div class="module-container" id="module_{{ $definitions['module_key'] }}">

    {{-- title --}}
    {!! Blade::renderComponent(new $title_view($definitions)) !!}

    {{-- info --}}
    {!! Blade::renderComponent(new $info_bar_view($definitions)) !!}

    <div class="module-body">

        {{-- last update --}}
        {!! Blade::renderComponent(new $last_update_view($mode, $records)) !!}

        <form method="post" action="{{ action([$controller, $formId!==null ? 'update' : 'store'], [$formId]) }}">

            @if($formId!==null)
                @method('PATCH')
            @endif

            {{-- crsf --}}
            @csrf

            {{--  Actions: not applicable / not available / other (custom) --}}
            <div class="flex justify-end">
                {!! Blade::renderComponent(new $not_applicable_view($definitions)) !!}
                {!! Blade::renderComponent(new $custom_action_view($definitions)) !!}
            </div>

            {{-- not applicable --}}
            <div v-show="not_applicable">
                <div class="no-data">
                    @lang('modular-forms::common.form.not_applicable')
                </div>
            </div>

            {{-- not available --}}
            <div v-show="not_available">
                <div class="no-data">
                    @lang('modular-forms::common.form.not_available')
                </div>
            </div>

            {{-- keep "observation" field even if not_applicable/not_available --}}
            {!! Blade::renderComponent(new $observations_view($definitions)) !!}

            <div v-show="!not_applicable && !not_available">

                {{-- ########################################################### --}}
                {{--    If a custom view does not exists use the standard one    --}}
                {{-- ########################################################### --}}
                @if(!view()->exists($custom_view_name))
                    <x-modular-forms::module.components.body
                        :collection="$collection"
                        :vueData="$vueData"
                        :definitions="$definitions"
                        :records="$records"
                        :mode="$mode"
                    ></x-modular-forms::module.components.body>

                    {!! Blade::renderComponent(new $script_view($collection, $vueData, $definitions, $records, $mode)) !!}

                @else
                    {{-- custom view --}}
                    @include($custom_view_name, compact(['collection', 'vueData', 'definitions', 'mode']))
                @endif

            </div>

        </form>

    </div>

    {!! Blade::renderComponent(new $action_bar_view($controller, $definitions, $vueData['records'], $mode)) !!}

</div>
