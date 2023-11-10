<?php
/** @var Mixed $definitions */
/** @var Mixed $records */
/** @var String $group_key (optional - only for GROUP_ACCORDION) */

$group_key = $group_key ?? null;

if($definitions['module_type']==='GROUP_ACCORDION'){
    $accordion_id = 'group_accordion_'.$definitions['module_key'].'_'.$group_key;
    $records = array_filter($records, function($item) use ($group_key, $definitions){
        return $item[$definitions['group_key_field']] === $group_key;
    });
} else {
    $accordion_id = 'accordion_'.$definitions['module_key'];
}

?>

<div class="accordion" id="{{ $accordion_id }}">

    @foreach($records as $index=>$record)
        <div class="accordion-item show">

            <div class="accordion-item-header">
                <div class="accordion-item-header-title">
                    <span>{{ $index+1 }} - </span>
                    <span>
                        @include('modular-forms::module.show.field', [
                            'type' => $definitions['fields'][0]['type'],
                            'value' => $record[$definitions['fields'][0]['name']],
                            'only_label' => true
                        ])
                    </span>
                </div>
            </div>

            <div class="accordion-item-body">
                <div class="accordion-item-body-content">
                    @include('modular-forms::module.show.type.simple', [
                        'definitions' => $definitions,
                        'records' => $records,
                        'index' => $index
                    ])
                </div>
            </div>

        </div>
    @endforeach

</div>
