<?php
/** @var Mixed $definitions */
/** @var Mixed $records */
/** @var String $group_key (optional - only for GROUP_TABLE) */

$group_key = $group_key ?? null;

if($definitions['module_type']==='GROUP_TABLE'){
    $table_id = 'group_table_'.$definitions['module_key'].'_'.$group_key;
    $records = array_filter($records, function($item) use ($group_key){
        return $item['group_key'] === $group_key;
    });
} else {
    $table_id = 'table_'.$definitions['module_key'];
}

?>

<table id="{{ $table_id }}"  class="table module-table">

    {{-- labels  --}}
    <thead>
        <tr>
            @foreach($definitions['fields'] as $f_index=>$field)
                <th class="text-center">{{ ucfirst($field['label'] ?? '') }}</th>
            @endforeach
        </tr>
    </thead>

    {{-- inputs --}}
    <tbody class="{{ $group_key }}">
        @foreach($records as $record)
            <tr class="module-table-item">
                @foreach($definitions['fields'] as $f_index=>$field)
                    <td>
                        @include('modular-forms::module.show.field', [
                            'type' => $field['type'],
                            'value' => $record[$field['name']]
                       ])
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>

</table>

