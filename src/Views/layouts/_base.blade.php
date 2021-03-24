<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">

    <head>
        @include('modular-forms::components.head')
    </head>

    <body>
        @yield('body')
    </body>

    @stack('scripts')

</html>
