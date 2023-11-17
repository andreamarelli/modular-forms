<?php
/** @var String $accordion_group_id */
/** @var String $accordion_id */
/** @var Boolean $expanded (optional) */
/** @slot $accordion_title */
/** @slot $accordion_title_action (optional) */
/** @slot $accordion_content */

$expanded  = $expanded ?? false;
$accordion_title_action = $accordion_title_action ?? '';

$show = $expanded ? 'class="show"' : '';

?>

<x-modular-forms::accordion.item {{ $show }}>

    <x-slot:title>
        {!! $accordion_title !!}
    </x-slot:title>
    <x-slot:header-actions>
        {!! $accordion_title_action !!}
    </x-slot:header-actions>

    {{ $accordion_content }}

</x-modular-forms::accordion.item>
