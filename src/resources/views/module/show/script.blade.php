<?php
/** @var \Illuminate\Database\Eloquent\Collection $collection */

?>

@push('scripts')
    <script>
        // ## Initialize Module controller ##
        let module_{{ $definitions['module_key'] }} = new Vue({
            el: '#module_{{ $definitions['module_key'] }}'
        });
    </script>
@endpush
