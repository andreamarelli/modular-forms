<?php
use AndreaMarelli\ModularForms\Helpers\Manifest;
use Illuminate\Support\Facades\App;

$debug = !App::environment('production');
$only_css = $only_css ?? false;

$window_js = [
    'csrfToken' => csrf_token(),
    'baseUrl' => url('/').'/',
    'locale' => App::getLocale()
]

?>

{{-- Stylesheets--}}
<link rel="stylesheet" href="{{ Manifest::asset('index.css', $debug) }}">

{{-- JavaScript--}}
@if(!$only_css)
    <script src="{{ Manifest::asset('vendor.js', $debug) }}"></script>
    <script src="{{ Manifest::asset('index.js', $debug) }}"></script>
    <script>
        window.Laravel = @json($window_js);
    </script>
@endif
