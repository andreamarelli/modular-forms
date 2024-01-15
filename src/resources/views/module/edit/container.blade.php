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
        {!! Blade::renderComponent(new $last_update_view($mode, $records)) !!}

        <form method="post" action="{{ action([$controller, $formId!==null ? 'update' : 'store'], [$formId]) }}">

            @if($formId!==null)
                @method('PATCH')
            @endif

            {{-- crsf --}}
            @csrf

            {{--  not applicable / not available / preload --}}
            <div class="text-right" style="margin: 0 0 10px;">
                {!! Blade::renderComponent(new $not_applicable_view($definitions)) !!}
                {!! Blade::renderComponent(new $preload_data_view($definitions)) !!}
            </div>

            {{-- kepp "observation" field even if not_applicable/not_available --}}
            {!! Blade::renderComponent(new $observations_view($definitions)) !!}

            <div v-show="!not_applicable && !not_available">

                {{-- ########################################################### --}}
                {{--    If a custom view does not exists use the standard one    --}}
                {{-- ########################################################### --}}
                @if(!view()->exists($default_model_view_name))
                    <x-modular-forms::module.components.body
                        :collection="$collection"
                        :vueData="$vueData"
                        :definitions="$definitions"
                        :mode="$mode"
                    ></x-modular-forms::module.components.body>
                    <x-modular-forms::module.components.script
                        :collection="$collection"
                        :vueData="$vueData"
                        :definitions="$definitions"
                    ></x-modular-forms::module.components.script>
                @else
                    {{-- custom view --}}
                    @include($default_model_view_name, compact(['collection', 'vueData', 'definitions', 'mode']))
                @endif

            </div>

        </form>

    </div>

    {{-- save bars --}}
    @include('modular-forms::module.components.save_bar')

</div>
