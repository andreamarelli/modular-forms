<?php
/** @var \Illuminate\Database\Eloquent\Collection $collection */
/** @var Mixed $definitions */
/** @var Mixed $vue_data */

?>

@foreach($definitions['groups'] as $group_key => $group_label)
    <h5 class="green group_title_{{ $definitions['module_key'] }}_{{ $group_key }}">{{ $group_label }}</h5>

    @include('modular-forms::module.edit.type.table', [
        'collection' => $collection,
        'definitions' => $definitions,
        'vue_data' => $vue_data,
        'group_key' => $group_key
    ])
    <br />
    <br />

@endforeach