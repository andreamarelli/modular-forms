<?php
/** @var Boolean $full_width (optional) */
/** @var Boolean $two_cols (optional) */

$full_width = $full_width ?? false;
$two_cols = $two_cols ?? false;

?>

@extends('modular-forms::layouts._base')


@section('body')

    <header>
        @include('modular-forms::layouts.components.header')
    </header>

    @if($full_width)
        <main>
            @yield('content')
        </main>
    @else

        @yield('page_header')

        <main class="container">

            @if($two_cols)
                <section class="main two-col row">
                    <nav class="sidebar col-lg-3">
                        @yield('page_sidebar')
                    </nav>
                    <div class="content col-lg-9">
                        @yield('page_content')
                    </div>
                </section>
            @else
                <section class="main one-col row">
                    <div class="content">
                        @yield('page_content')
                    </div>
                </section>
            @endif

        </main>

    @endif

    <footer>
        @include('modular-forms::layouts.components.footer')
    </footer>

@endsection


@if($two_cols)
    @push('scripts')
        <script>
            window.onload = function() {

                document.querySelectorAll('.sidebar > ul > li')
                    .forEach(function(item) {
                        if(!item.classList.contains('selected')){
                            let second_level = item.querySelector('ul');
                            if(second_level!==null){
                                item.addEventListener("mouseover", function () {
                                    second_level.classList.add('hover');
                                });
                                item.addEventListener("mouseout", function () {
                                    second_level.classList.remove('hover');
                                });
                            }
                        }
                    });

            }
        </script>
    @endpush
@endif
