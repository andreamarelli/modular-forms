<?php

use AndreaMarelli\ModularForms\View\Module\Container;
use Illuminate\Support\Facades\Blade;

?>

<div class="module-container" id="module_{{ $definitions['module_key'] }}">

    {{-- title --}}
    {!! Blade::renderComponent(new $title_view($definitions)) !!}

    {{-- info --}}
    {!! Blade::renderComponent(new $info_view($definitions)) !!}

    <div class="module-body">

        {{-- last update --}}
        {!! Blade::renderComponent(new $last_update_view($mode, $last_update)) !!}

        {{-- not applicable / not available --}}
        @if(!$noData && array_key_exists('not_applicable', $records[0]) && $records[0]['not_applicable'])
            <div class="no-data">
                @lang('modular-forms::common.form.not_applicable')
            </div>
        @elseif(!$noData && array_key_exists('not_available', $records[0]) && $records[0]['not_available'])
            <div class="no-data">
                @lang('modular-forms::common.form.not_available')
            </div>
        @elseif($mode===Container::MODE_PRINT && $noData)
            <div class="no-data">
                @lang('modular-forms::common.data_not_available')
            </div>
        @else

            {{-- ########################################################### --}}
            {{--    If a custom view does not exists use the standard one    --}}
            {{-- ########################################################### --}}
            @if(!view()->exists($default_model_view_name))
                <x-modular-forms::module.components.body
                    :collection="$collection"
                    :vueData="$vueData"
                    :definitions="$definitions"
                    :records="$records"
                    :mode="$mode"
                ></x-modular-forms::module.components.body>
            @else
                {{-- custom view --}}
                @include($default_model_view_name, compact(['collection', 'records', 'definitions', 'mode']))
            @endif

            @include('modular-forms::module.show.script', compact(['definitions']))

        @endif

    </div>

    @if($mode===Container::MODE_VALIDATE)
        @include('modular-forms::module.components.validation_bar', compact(['controller', 'definitions', 'validation']))
    @endif

</div>
