<?php

use AndreaMarelli\ModularForms\Helpers\Manifest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Vite;

$debug = !App::environment('production');
$only_css = $only_css ?? false;

$window_js = [
    'csrfToken' => csrf_token(),
    'baseUrl' => url('/') . '/',
    'locale' => App::getLocale()
];

?>

@if(!$only_css)
    <script>
        window.Laravel = @json($window_js);
    </script>
@endif


