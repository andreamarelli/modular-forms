<?php
    /** @var String $type */
    /** @var String $v_value */
    /** @var String $id [optional] */
    /** @var String $class [optional] */
    /** @var String $rules [optional] */
    /** @var String $other [optional] */
    /** @var String $module_key */

    // Ensure at least empty strings
    $id = $id ?? '';
    $class = $class ?? '';
    $rules = $rules ?? '';
    $other = $other ?? '';

    // Set Vue attributes
    $v_bind_id = $id!=='' ? 'v-bind:id="'.$id.'"' : '';
    $v_model = 'v-model="'.$v_value.'"';
    $vue_attributes = $v_model . ' ' .$v_bind_id;

    // Set other attributes
    $class .= ' field-edit';
    $rules = $rules!=='' ? 'data-rules="'.$rules.'"' : '';

?>


{{--  ######  Use given blade template  ###### --}}
@if(substr_count($type, "blade-")>0)
    @include(explode('-', $type)[1], [
        'v_model' => $v_model,
        'v_bind_id' => $v_bind_id,
        'class' => $class,
        'other' => $other,
        'rules' => $rules,
        'type' => $type,
        'module_key' => $definitions['module_key']
    ])

{{--  ###### disabled ######  --}}
@elseif($type=="disabled")
    <input type="text" disabled="disabled" {!! $vue_attributes !!} class="{!! $class !!}" {!! $other !!} />


{{--  ###### hidden ######  --}}
@elseif($type=="hidden")
    <input type="hidden" {!! $vue_attributes !!} {!! $other !!} />


{{--  ###### textual simple inputs ######  --}}
@elseif($type=="text")
    <simple-text {!! $vue_attributes !!} {!! $rules !!} {!! $other !!}></simple-text>
@elseif($type=="text-area")
    <simple-textarea {!! $vue_attributes !!} {!! $rules !!} {!! $other !!}></simple-textarea>
@elseif($type=="url")
    <simple-url {!! $vue_attributes !!} {!! $rules !!} {!! $other !!}></simple-url>
@elseif($type=="email")
    <simple-email {!! $vue_attributes !!} {!! $rules !!} {!! $other !!}></simple-email>
@elseif($type=="password")
    <simple-password {!! $vue_attributes !!} {!! $rules !!} {!! $other !!}></simple-password>
@elseif($type=="date")
    <simple-date {!! $vue_attributes !!} {!! $rules !!} {!! $other !!}></simple-date>


{{--  ###### numeric inputs ######  --}}
@elseif($type=="integer" || $type=='numeric' || $type=='float' || $type=='currency' || $type=='code')
    <simple-numeric numeric-type="{!! $type !!}" {!! $vue_attributes !!} {!! $rules !!} {!! $other !!}></simple-numeric>


{{--  ###### date ######  --}}
@elseif($type==="date")
    <simple-date {!! $vue_attributes !!} {!! $rules !!} {!! $other !!}></simple-date>
@elseif($type==="year")
    <simple-date date-type="year" {!! $vue_attributes !!} {!! $rules !!} {!! $other !!}></simple-date>
@elseif($type==="dateMaxToday")
    <simple-date end-date="{{ date("Y-M-d") }}" {!! $vue_attributes !!} {!! $rules !!} {!! $other !!}></simple-date>
@elseif($type==="yearMaxCurrent")
    <simple-date date-type="year" end-date="{{ date("Y") }}-01-01" {!! $vue_attributes !!} {!! $rules !!} {!! $other !!}></simple-date>
@elseif($type==="yearMaxPrev")
    <simple-date date-type="year" end-date="{{ date("Y")-1 }}-01-01" {!! $vue_attributes !!} {!! $rules !!} {!! $other !!}></simple-date>


{{--  #######  LISTS #######  --}}
@elseif(substr_count($type, "dropdown")>0
    || substr_count($type, "suggestion")>0
    || substr_count($type, "toggle")>0
    || substr_count($type, "checkbox")>0)

    <?php
        $list_type = \AndreaMarelli\ModularForms\Helpers\Input\SelectionList::getListType($type);
        $cached_list = \AndreaMarelli\ModularForms\Helpers\Input\SelectionList::CacheListInSession($list_type);
    ?>

    {{-- ## empty list ## --}}
    @if(empty($cached_list)
        && $type!=='checkbox-boolean'
        && $type!=='checkbox-boolean_numeric')
        <b class="text-danger">List "{{ $list_type }}" is missing. Not been implemented yet.</b>

    {{-- ## dropdowns ## --}}
    @elseif(substr_count($type, "dropdown-")>0)
        <dropdown
            data-values='@json($cached_list)'
            {!! $vue_attributes !!} {!! $rules !!} {!! $other !!}
        ></dropdown>
    @elseif(substr_count($type, "suggestion-")>0)
        <dropdown
            data-values='@json($cached_list)'
            :taggable=true
            {!! $vue_attributes !!} {!! $rules !!} {!! $other !!}
        ></dropdown>
    @elseif(substr_count($type, "dropdown_multiple-")>0)
        <dropdown
            :multiple="true"
            data-values='@json($cached_list)'
            {!! $vue_attributes !!} {!! $rules !!} {!! $other !!}
        ></dropdown>
    @elseif(substr_count($type, "dropdown_entity-")>0)
        <dropdown-entity
            data-values='@json($cached_list)'
            entity-key="{!! Str::lower($list_type) !!}"
            {!! $vue_attributes !!} class="{!! $class !!}" {!! $rules !!} {!! $other !!}
        >
            @include('admin.'.strtolower($list_type).'.'.'create-modal')
        </dropdown-entity>

    {{-- ## toggle ## --}}
    @elseif(substr_count($type, "toggle-")>0)
        <toggle
            data-values='@json($cached_list)'
            {!! $vue_attributes !!} {!! $rules !!} {!! $other !!}
        ></toggle>

    {{-- ## checkbox ## --}}
    @elseif(substr_count($type, "checkbox-")>0)
        @if($type=="checkbox-boolean")
            <checkbox-boolean
                    {!! $vue_attributes !!} data-class="{!! $class !!}" {!! $rules !!} {!! $other !!}
            ></checkbox-boolean>
        @elseif($type=="checkbox-boolean_numeric")
            <checkbox-boolean
                    :data-numeric=true
                    {!! $vue_attributes !!} data-class="{!! $class !!}" {!! $rules !!} {!! $other !!}
            ></checkbox-boolean>
        @else
            @foreach($cached_list as $checkbox_value => $checkbox_label)
                <input
                    type="checkbox"
                    {!! $v_model !!}
                    :id="index+'_{{ AndreaMarelli\ModularForms\Helpers\Type\Chars::clean($checkbox_value) }}'"
                    value="{{ $checkbox_value }}"
                    {!! $other !!}
                /><span class="checkbox_label">{{ $checkbox_label }}</span><br />
            @endforeach
        @endif
    @endif


{{--  ###### rating ######  --}}
@elseif(substr_count($type, "rating-")>0)
<rating
        rating-type="{{ str_replace('rating-', '', $type) }}"
        {!! $vue_attributes !!} data-class="{!! $class !!}" {!! $rules !!} {!! $other !!}
></rating>


{{--  ###### file upload ######  --}}
@elseif($type=="upload")
<upload
        {!! $vue_attributes !!} data-class="{!! $class !!}" {!! $rules !!} {!! $other !!}
></upload>


{{--  ###### text editor ######  --}}
@elseif($type=="text-editor")
<editor v-model="{{ $v_value }}" v-on:update="{{ $v_value }} = $event"></editor>

@else
<b class="text-danger">Type "{{ $type }}" has not been implemented yet.</b>
@endif