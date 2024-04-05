@push('scripts')
    <script type="module">
        // ## Initialize Module controller ##
       (new window.ModularForms.BaseApp())
           .mount('#module_{{ $definitions['module_key'] }}');
    </script>
@endpush
