<?php
/** @var \Illuminate\Database\Eloquent\Collection $collection */

?>

@push('scripts')
    <script>
        // ## Initialize Module controller ##
        new Vue({
            el: '#module_{{ $definitions['module_key'] }}'
        });
    </script>
@endpush
