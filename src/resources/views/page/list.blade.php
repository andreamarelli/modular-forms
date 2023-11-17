<?php
/** @var AndreaMarelli\ModularForms\Controllers\Controller $controller */
/** @var Illuminate\Http\Request $request */
/** @var Illuminate\Pagination\LengthAwarePaginator $list */

$num_records = $list instanceof \Illuminate\Pagination\LengthAwarePaginator ? $list->total() : count($list);

?>

@extends('modular-forms::layouts.forms')

@section('content')

    <div id="page-container">

        {{-- Functional buttons --}}
        @hasSection('functional-buttons')
            <div class="functional_buttons">
                @yield('functional-buttons')
            </div>
        @endif

       {{-- Filters --}}
        @component('modular-forms::page.components.filters', [
            'controller' => $controller,
            'request' => $request
        ])
            @slot('content')
                @yield('filters')
            @endslot
        @endcomponent

        {{--  Pagination  --}}
        @include('modular-forms::page.components.pagination', ['list'=> $list])

        {{-- form list table --}}
        <table class="striped" id="item_list_table">
            <thead>
                <tr>
                    @yield('list-header')
                </tr>
            </thead>
            <tbody>
                @if($num_records>0)
                    @yield('list-body')
                @else
                    <tr>
                        <td class="text-center" colspan="100%">
                            @lang('common.no_data_found')
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

    </div>

    @push('scripts')
        <script>
            new Vue({
                el: '#page-container',
            });
        </script>
    @endpush

@endsection