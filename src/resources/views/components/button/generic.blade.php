<a role="button"
    {{ $attributes->merge(['class' => 'btn-nav']) }}
    {{ $href() }}
    {{ $newPage ? 'target="_blank"' : '' }}
>
    {!! $text !!}
</a>
@if($tooltip)
    <tooltip>{{ $tooltip }}</tooltip>
@endif
