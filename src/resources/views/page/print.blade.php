<?php
/** @var \ModularForms\Controllers\Controller $controller */
/** @var \ModularForms\Models\Form $item */
/** @var string $mode */

?>

@extends('modular-forms::layouts.print')

@section('content')

    {{--  Heading --}}
    <div class="entity-heading">
        @yield('heading')
    </div>

    {{--  Modules (all steps) --}}
    @foreach(array_keys($item::modules()) as $step)

        {{--  Modules (by steps) --}}
        @include('modular-forms::page.components.modules', [
            'controller' => $controller,
            'item' => $item,
            'step' => $step,
            'mode' => \ModularForms\Enums\ModuleViewModes::PRINT
        ])

    @endforeach

@endsection
