<?php
/** @var \AndreaMarelli\ModularForms\Controllers\Controller $controller */
/** @var \AndreaMarelli\ModularForms\Models\Form $item */
/** @var string $step */
/** @var string $mode "edit" or "show" */

?>


{{--  Modules (by step) --}}
@foreach($item::modules()[$step] as $module)
    @include('modular-forms::module.' . $mode . '.container', [
        'controller' => $controller,
        'module_class' => $module,
        'form_id' => $item->getKey()
    ])
@endforeach
