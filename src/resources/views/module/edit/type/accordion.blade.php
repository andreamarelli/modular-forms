<?php
/** @var \Illuminate\Database\Eloquent\Collection $collection */
/** @var Mixed $definitions */
/** @var Mixed $vue_data */
/** @var String $group_key (optional - only for GROUP_ACCORDION) */

$group_key = $group_key ?? '';

if($definitions['module_type']==='GROUP_ACCORDION'){
    $accordion_id = 'group_accordion_'.$definitions['module_key'].'_'.$group_key;
    $accordion_item_record = 'records[\''.$group_key.'\']';
    $accordion_titles = '{{ typeof accordion_titles[\''.$group_key.'\'] !== "undefined"  && typeof accordion_titles[\''.$group_key.'\'][index]!=="undefined" ? accordion_titles[\''.$group_key.'\'][index] : "" }}';
} else {
    $accordion_id = 'accordion_'.$definitions['module_key'];
    $accordion_item_record = 'records';
    $accordion_titles = '{{  accordion_titles[index] }}';
}

?>

<x-modular-forms::accordion.container id="{{ $accordion_id }}">

    <x-modular-forms::accordion.item v-for="(item, index) in {{ $accordion_item_record }}">

        <x-slot:title>
            <span>@{{ parseInt(index) + 1 }} - </span><span>{{ $accordion_titles }}</span>
        </x-slot:title>

        <x-slot:header-actions>
            @if(!$definitions['fixed_rows'])
                <span v-if="typeof item.__predefined === 'undefined'">
                        @include('modular-forms::buttons.delete_item')
                    </span>
            @endif
        </x-slot:header-actions>

        @include('modular-forms::module.edit.type.simple', compact(['collection', 'vue_data', 'definitions']))

    </x-modular-forms::accordion.item>

</x-modular-forms::accordion.container>


@if(!$definitions['fixed_rows'])
    <div v-if="max_rows==null || {{ $accordion_item_record }}.length < max_rows" class="module-row">
        @include('modular-forms::buttons.add_item')
    </div>
@endif
