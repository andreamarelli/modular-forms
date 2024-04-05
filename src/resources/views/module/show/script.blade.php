@push('scripts')
    <script type="module">
        // ## Initialize Module controller ##
       (new window.ModularForms.App())
           .mount('#module_{{ $definitions['module_key'] }}');
    </script>
@endpush
