<?php
/** @var \AndreaMarelli\ModularForms\Controllers\Controller $controller */
/** @var \AndreaMarelli\ModularForms\Models\Form $item */
/** @var string $step */
/** @var string $label_prefix */

?>

@extends('modular-forms::layouts.forms')

@section('content')

    {{--  Heading --}}
    <div class="entity-heading">
       @yield('header')
    </div>

    {{--  Steps menu --}}
    @include('modular-forms::page.components.steps', [
        'url' => action([$controller, 'edit'], ['item' => $item->getKey()]),
        'current_step' => $step,
        'label_prefix' =>  $label_prefix.'.steps.',
        'steps' => array_keys($item::modules())
    ])

    {{-- Global errors --}}
    @include('modular-forms::page.components.errors', [
        'url' => action([$controller, 'edit'], ['item' => $item->getKey()]),
        'item' => $item
    ])

    {{--  Modules (by step) --}}
    @foreach($item::modules()[$step] as $module)
        @include('modular-forms::module.edit.container', [
            'controller' => $controller,
            'module_class' => $module,
            'form_id' => $item->getKey()
        ])
    @endforeach
    
@endsection
