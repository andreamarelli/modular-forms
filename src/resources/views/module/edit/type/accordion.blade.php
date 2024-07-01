<?php
/** @var \Illuminate\Database\Eloquent\Collection $collection */
/** @var Mixed $definitions */
/** @var Mixed $vueData */
/** @var String $group_key (optional - only for GROUP_ACCORDION) */

$group_key = $group_key ?? '';

if(\Illuminate\Support\Str::contains($definitions['module_type'], 'GROUP_')){
    $accordion_id = 'group_accordion_'.$definitions['module_key'].'_'.$group_key;
    $accordion_titles = '{{ accordion_titles[\''.$group_key.'\'][indexInGroup(index, \''.$group_key.'\')] }}';
} else {
    $accordion_id = 'accordion_'.$definitions['module_key'];
    $accordion_titles = '{{  accordion_titles[index] }}';
}

?>


<x-modular-forms::accordion.container id="{{ $accordion_id }}">

    <template v-for="(item, index) in records">

    <x-modular-forms::accordion.item v-if="recordIsInGroup(item, '{{ $group_key }}')">

        <x-slot:title>
            <span v-html="(indexInGroup(index, '{{ $group_key }}') + 1) + ' - '"></span><span>{!! $accordion_titles !!}</span>
        </x-slot:title>

        <x-slot:header-actions>
            @if(!$definitions['fixed_rows'])
                <span v-if="typeof item.__predefined === 'undefined'">
                        @include('modular-forms::buttons.delete_item')
                    </span>
            @endif
        </x-slot:header-actions>

        @include('modular-forms::module.edit.type.simple', compact(['collection', 'vueData', 'definitions']))

    </x-modular-forms::accordion.item>

    </template>

    @if(!$definitions['fixed_rows'])
        <div v-if="max_rows==null || numRecordsInGroup('{{ $group_key }}') < max_rows">
            @include('modular-forms::buttons.add_item')
        </div>
    @endif


</x-modular-forms::accordion.container>



