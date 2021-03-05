<?php
/** @var Mixed $definitions */
?>

<div class="module-header">
    @if($definitions['module_code']!==null)
        <div class="module-code text-center">
            {!! ucfirst($definitions['module_code']) !!}
        </div>
    @endif
    <div class="module-title">
        {!! ucfirst($definitions['module_title']) !!}
    </div>
    <div class="module-info">
        @include('modular-forms::module.info.modal', ['definitions' => $definitions])
    </div>
</div>
