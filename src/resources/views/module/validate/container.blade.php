<?php
$only_show = $only_show ?? false;

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
            @if(!view()->exists($body_view))
                @include('modular-forms::module.show.body', compact(['definitions', 'records']))
            @else
                @include($body_view, compact(['collection', 'definitions', 'records']))
            @endif

        @endif

    </div>

    {{-- bars: validation --}}
    @if($only_show)
        <div class="module-bar info-bar">
            <div class="message"></div>
            <div class="buttons">
                {!! \AndreaMarelli\ModularForms\Helpers\Template::icon('info-circle') !!}
                @lang('modular-forms::common.form.already_validated')
            </div>
        </div>
    @elseif(!$no_data)
        @include('modular-forms::module.validation_bar', [
            'controller' => $controller,
            'definitions' => $definitions,
            'validation' => $module_records['validation']
            ])
    @endif

</div>
