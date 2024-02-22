<?php
/** @var AndreaMarelli\ModularForms\Controllers\Controller $controller */
/** @var \AndreaMarelli\ModularForms\Models\Module $module */

?>

@extends('modular-forms::layouts.forms')

@section('content')

    {{-- Create module --}}
    <x-modular-forms::module.container
        :controller="$controller"
        :module="$module"
        :formId="null"
        :mode="\AndreaMarelli\ModularForms\View\Module\Container::MODE_EDIT"
    ></x-modular-forms::module.container>

@endsection
