<?php
/** @var string $content */
/** @var string $controller */
/** @var \Illuminate\Http\Request $request [optional] */

use \Illuminate\Support\Str;

?>

<x-modular-forms::accordion.container class="form-filters">

    <x-modular-forms::accordion.item title="{{ Str::upper(trans('modular-forms::common.filters')) }}">

        <form class="form-horizontal" method="GET" action="{{ action([$controller, 'index']) }}">
            {{ csrf_field() }}

            <div class="form-grid">
                {{ $content }}
            </div>

            <div class="text-right">
                <button type="submit" class="btn-nav rounded">{{ Str::ucfirst(trans('modular-forms::common.apply_filters')) }}</button>
            </div>

        </form>

    </x-modular-forms::accordion.item>

</x-modular-forms::accordion.container>
