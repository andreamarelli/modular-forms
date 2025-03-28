<?php
    /** @var String $type */
    /** @var String $id */
    /** @var String $value */
    /** @var String $class [optional] */
    /** @var bool $disableJs [optional] */

    $class = $class ?? '';
    $class .= ' field-edit';

?>

@if($type=="preview")
    <div class="field-preview">{!! $value !!}</div>

@elseif($type=="hidden")
    {!! \ModularForms\Helpers\Input\Input::hidden($id, $value)  !!}

@elseif($type=="text")
    {!! \ModularForms\Helpers\Input\Input::text($id, $value, $class) !!}

@elseif($type=="date")
    {!! \ModularForms\Helpers\Input\Input::dayPicker($id, $value, $class) !!}

@elseif(substr_count($type, "dropdown-")>0)
    {!! \ModularForms\Helpers\Input\DropDown::simple($id, $value, str_replace('dropdown-', '', $type), $class) !!}

@else
    <b class="error">Type "{{ $type }}" has not been implemented yet.</b>
@endif
