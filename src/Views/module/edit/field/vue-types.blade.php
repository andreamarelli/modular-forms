<?php
    /** @var String $type */
    /** @var String $v_value */
    /** @var String $id [optional] */
    /** @var String $class [optional] */
    /** @var String $rules [optional] */
    /** @var String $other [optional] */
    /** @var String $module_key [optional] */

    $id = $id ?? '';
    $class = $class ?? '';
    $rules = $rules ?? '';
    $other = $other ?? '';

    $vue_attributes = \AndreaMarelli\ModularForms\Helpers\DOM::vueAttributes($id, $v_value);
    $class_attribute = \AndreaMarelli\ModularForms\Helpers\DOM::addClass($class, 'field-edit');
    $rules_attribute = \AndreaMarelli\ModularForms\Helpers\DOM::rulesAttribute($rules);
    $other_attributes = $other ?? '';

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
        'module_key' => $module_key
    ])

{{--  ###### disabled ######  --}}
@elseif($type=="disabled")
    <input type="text" disabled="disabled" {!! $vue_attributes !!} {!! $class_attribute !!} {!! $other_attributes !!} />


{{--  ###### hidden ######  --}}
@elseif($type=="hidden")
    <input type="hidden" {!! $vue_attributes !!} {!! $other_attributes !!} />


{{--  ###### textual simple inputs ######  --}}
@elseif($type=="text")
    <simple-text {!! $vue_attributes !!} {!! $rules_attribute !!} {!! $other_attributes !!}></simple-text>
@elseif($type=="text-area")
    <simple-textarea {!! $vue_attributes !!} {!! $rules_attribute !!} {!! $other_attributes !!}></simple-textarea>
@elseif($type=="url")
    <simple-url {!! $vue_attributes !!} {!! $rules_attribute !!} {!! $other_attributes !!}></simple-url>
@elseif($type=="email")
    <simple-email {!! $vue_attributes !!} {!! $rules_attribute !!} {!! $other_attributes !!}></simple-email>
@elseif($type=="password")
    <simple-password {!! $vue_attributes !!} {!! $rules_attribute !!} {!! $other_attributes !!}></simple-password>
@elseif($type=="date")
    <simple-date {!! $vue_attributes !!} {!! $rules_attribute !!} {!! $other_attributes !!}></simple-date>


{{--  ###### numeric inputs ######  --}}
@elseif($type=="integer"
    || $type=='numeric'
    || $type=='float'
    || $type=='currency'
    || $type=='code')
    <simple-numeric numeric-type="{!! $type !!}" {!! $vue_attributes !!} {!! $rules_attribute !!} {!! $other_attributes !!}></simple-numeric>


{{--  ###### date ######  --}}
@elseif($type==="date")
    <simple-date {!! $vue_attributes !!} {!! $rules_attribute !!} {!! $other_attributes !!}></simple-date>
@elseif($type==="year")
    <simple-date date-type="year" {!! $vue_attributes !!} {!! $rules_attribute !!} {!! $other_attributes !!}></simple-date>
@elseif($type==="dateMaxToday")
    <simple-date end-date="{{ date("Y-M-d") }}" {!! $vue_attributes !!} {!! $rules_attribute !!} {!! $other_attributes !!}></simple-date>
@elseif($type==="yearMaxCurrent")
    <simple-date date-type="year" end-date="{{ date("Y") }}-01-01" {!! $vue_attributes !!} {!! $rules_attribute !!} {!! $other_attributes !!}></simple-date>
@elseif($type==="yearMaxPrev")
    <simple-date date-type="year" end-date="{{ date("Y")-1 }}-01-01" {!! $vue_attributes !!} {!! $rules_attribute !!} {!! $other_attributes !!}></simple-date>


{{--  #######  LISTS #######  --}}
@elseif(substr_count($type, "dropdown")>0
    || substr_count($type, "suggestion")>0
    || substr_count($type, "toggle")>0
    || substr_count($type, "checkbox")>0)

    <?php
        $list_type = \AndreaMarelli\ModularForms\Helpers\Input\SelectionList::getListType($type);
        $cached_list = \AndreaMarelli\ModularForms\Helpers\Input\SelectionList::CacheListInSession($list_type);
    ?>

    {{-- ## dropdowns ## --}}
    @if(substr_count($type, "dropdown-")>0)
        <dropdown
            data-values='@json($cached_list)'
            {!! $vue_attributes !!} {!! $rules_attribute !!} {!! $other_attributes !!}
        ></dropdown>
    @elseif(substr_count($type, "suggestion-")>0)
        <dropdown
            data-values='@json($cached_list)'
            :taggable=true
            {!! $vue_attributes !!} {!! $rules_attribute !!} {!! $other_attributes !!}
        ></dropdown>
    @elseif(substr_count($type, "dropdown_multiple-")>0)
        <dropdown
            :multiple="true"
            data-values='@json($cached_list)'
            {!! $vue_attributes !!} {!! $rules_attribute !!} {!! $other_attributes !!}
        ></dropdown>
    @elseif(substr_count($type, "dropdown_entity-")>0)
        <dropdown-entity
            data-values='@json($cached_list)'
            entity-key="{!! Str::lower($list_type) !!}"
            {!! $vue_attributes !!} {!! $class_attribute !!} {!! $rules_attribute !!} {!! $other_attributes !!}
        >
            @include('admin.'.strtolower($list_type).'.'.'create-modal')
        </dropdown-entity>

    {{-- ## toggle ## --}}
    @elseif(substr_count($type, "toggle-")>0)
        <toggle
            data-values='@json($cached_list)'
            {!! $vue_attributes !!} {!! $rules_attribute !!} {!! $other_attributes !!}
        ></toggle>

    {{-- ## checkbox ## --}}
    @elseif(substr_count($type, "checkbox-")>0)
        @if($type=="checkbox-boolean")
            <checkbox-boolean
                    {!! $vue_attributes !!} data-{!! $class_attribute !!} {!! $rules_attribute !!} {!! $other_attributes !!}
            ></checkbox-boolean>
        @elseif($type=="checkbox-boolean_numeric")
            <checkbox-boolean
                    :data-numeric=true
                    {!! $vue_attributes !!} data-{!! $class_attribute !!} {!! $rules_attribute !!} {!! $other_attributes !!}
            ></checkbox-boolean>
        @else
            @foreach($cached_list as $checkbox_value => $checkbox_label)
                <input
                    type="checkbox"
                    {!! $v_model !!}
                    :id="index+'_{{ AndreaMarelli\ModularForms\Helpers\Type\Chars::clean($checkbox_value) }}'"
                    value="{{ $checkbox_value }}"
                    {!! $other_attributes !!}
                /><span class="checkbox_label">{{ $checkbox_label }}</span><br />
            @endforeach
        @endif
    @endif


{{--  ###### rating ######  --}}
@elseif(substr_count($type, "rating-")>0)
<rating
        rating-type="{{ str_replace('rating-', '', $type) }}"
        {!! $vue_attributes !!} data-{!! $class_attribute !!} {!! $rules_attribute !!} {!! $other_attributes !!}
></rating>


{{--  ###### file upload ######  --}}
@elseif($type=="upload")
<upload
        {!! $vue_attributes !!} data-{!! $class_attribute !!} {!! $rules_attribute !!} {!! $other_attributes !!}
></upload>


{{--  ###### text editor ######  --}}
@elseif($type=="text-editor")
<editor v-model="{{ $v_value }}" v-on:update="{{ $v_value }} = $event"></editor>

@else
<b class="text-danger">Type "{{ $type }}" has not been implemented yet.</b>
@endif
