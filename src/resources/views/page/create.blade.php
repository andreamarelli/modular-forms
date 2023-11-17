<?php
/** @var AndreaMarelli\ModularForms\Controllers\Controller $controller */
/** @var \AndreaMarelli\ModularForms\Models\Module $module */

?>

@extends('modular-forms::layouts.forms')

@section('content')

    {{-- Create module --}}
    @include('modular-forms::module.edit.container', [
        'controller' => $controller,
        'module_class' => $module,
        'form_id' => null
    ])

@endsection
