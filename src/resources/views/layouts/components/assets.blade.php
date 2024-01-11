<?php
use AndreaMarelli\ModularForms\Helpers\Manifest;
use Illuminate\Support\Facades\App;

$debug = !App::environment('production');

$window_js = [
    'csrfToken' => csrf_token(),
    'baseUrl' => url('/').'/',
    'locale' => App::getLocale()
]

?>

<script src="{{ Manifest::asset('vendor.js', $debug) }}"></script>
<script src="{{ Manifest::asset('index.js', $debug) }}"></script>
<link rel="stylesheet" href="{{ Manifest::asset('index.css', $debug) }}">

<script>
    window.Laravel = @json($window_js);
</script>
