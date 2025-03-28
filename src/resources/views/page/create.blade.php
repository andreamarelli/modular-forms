<?php
/** @var \ModularForms\Controllers\Controller $controller */
/** @var \ModularForms\Models\Module $module */

?>

@extends('modular-forms::layouts.forms')

@section('content')

    {{-- Title --}}
    @hasSection('page-title')
        <div class="page-title">
            @yield('page-title')
        </div>
    @endif

    {{-- Create module --}}
    <x-modular-forms::module.container
        :controller="$controller"
        :module="$module"
        :formId="null"
        :mode="\ModularForms\Enums\ModuleViewModes::EDIT"
    ></x-modular-forms::module.container>

@endsection
