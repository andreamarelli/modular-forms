
<div {{ $attributes->merge(['class' => 'accordion']) }} {{ $id ? 'id="' . $id . '"' : '' }}>
    {{ $slot }}
</div>
