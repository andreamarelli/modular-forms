@if($mode===\AndreaMarelli\ModularForms\View\Module\Container::MODE_EDIT)
    <p class="text-right module-log" v-if="last_update!=null && last_update.id!=null">
        @lang('modular-forms::entities.common.last_update'):&nbsp;
        <b>@{{ last_update.name }}</b>
        <i>@{{ last_update.date }}</i>
    </p>
@else
    @if(isset($last_update) && $last_update['date']!==null)
        <p class="text-right module-log">
            @lang('modular-forms::entities.common.last_update'):&nbsp;
            <b>{{ $last_update['name'] }}</b>
            <i>{{ $last_update['date'] }}</i>
        </p>
    @endif
@endif
