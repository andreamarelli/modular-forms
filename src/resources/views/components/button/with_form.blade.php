<form style="display: inline-block" method="{{ $form_method }}" {{ $form_action() }}>
    @csrf
    {!! $hidden_inputs !!}

    <button type="submit"
        {{ $attributes->merge(['class' => 'btn-nav']) }}
    >
        {!! $text !!}
    </button>

    @if($tooltip)
        <tooltip>{{ $tooltip }}</tooltip>
    @endif
</form>
