<?php
/** @var \AndreaMarelli\ModularForms\Controllers\Controller $controller */
/** @var \AndreaMarelli\ModularForms\Models\Form $item */
/** @var string $step */
/** @var string $label_prefix */
/** @var boolean $show_scrollbar [optional] */

$show_scrollbar = $show_scrollbar ?? true;

?>

@extends('modular-forms::layouts.forms')

@section('content')

    {{--  Heading --}}
    <div class="entity-heading">
        @yield('heading')
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
    @include('modular-forms::page.components.modules', [
        'controller' => $controller,
        'item' => $item,
        'step' => $step,
        'mode' => \AndreaMarelli\ModularForms\View\Module\Container::MODE_EDIT
    ])

    {{--  Scroll buttons  --}}
    @if($show_scrollbar)
        @include('modular-forms::module.scroll', ['item' => $item, 'step' => $step])
    @endif

@endsection
