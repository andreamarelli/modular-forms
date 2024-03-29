<?php
/** @var Boolean $full_width (optional) */
/** @var Boolean $two_cols (optional) */

$full_width = $full_width ?? false;
$two_cols = $two_cols ?? false;

?>

@extends('modular-forms::layouts._base', ['class_to_body' => 'flex-col'])


@section('body')

    <header>
        @include('modular-forms::layouts.components.header')
    </header>

    @if($full_width)
        <main>
            @yield('page_content')
        </main>
    @else

        @yield('page_header')


        @if($two_cols)
            <main class="two-col">
                <nav class="sidebar">
                    <div id="sidebar_menu_anchor_mobile" class="btn-nav tag">
                        <i class="fas fa-bars"></i>
                        @yield('page_sidebar_anchor_label')
                    </div>
                    <div class="sidebar_menu">
                        <i class="sidebar_close_button fas fa-times"></i>
                        @yield('page_sidebar')
                    </div>
                </nav>
                <section class="content">
                    @yield('page_content')
                </section>
            </main>
        @else
            <main class="one-col">
                <section class="content">
                    @yield('page_content')
                </section>
            </main>
        @endif


    @endif

    <footer>
        @include('modular-forms::layouts.components.footer')
    </footer>

@endsection


@if($two_cols)
    @push('scripts')
        <script>
            window.onload = function() {

                // Responsive sidebar
                document.querySelector('#sidebar_menu_anchor_mobile').addEventListener('click', function(){
                    document.querySelector('.sidebar_menu').classList.add('active');
                });
                document.querySelector('.sidebar_close_button').addEventListener('click', function(){
                    document.querySelector('.sidebar_menu').classList.remove('active');
                });

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
