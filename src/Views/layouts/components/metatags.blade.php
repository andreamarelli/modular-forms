<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="{{ url('/') }}/favicon.ico" type="image/x-icon" rel="icon">

<script>
    {!! 'window.Laravel = '.json_encode([
        'csrfToken' => csrf_token(),
        'baseUrl' => url('/').'/'
    ]).';' !!}
</script>
