<?php
use AndreaMarelli\ModularForms\Helpers\Manifest;
use Illuminate\Support\Facades\App;

$debug = !App::environment('production');
?>

<script src="{{ Manifest::asset('mapbox.js', $debug) }}"></script>
<link rel="stylesheet" href="{{ Manifest::asset('mapbox.css', $debug) }}">
<script>
    window.mapboxgl.accessToken = '{{ env('MAPBOX_ACCESS_TOKEN') }}';
</script>
