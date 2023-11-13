<?php
/** @var string $filter_content */
/** @var string $url */
/** @var string $method [optional] */
/** @var \Illuminate\Http\Request $request [optional] */
/** @var boolean $expanded [optional] */
/** @var boolean $accordion_title [optional] */
/** @var boolean $submit_button_label [optional] */

use Illuminate\Support\Str;

$method              = $method ?? 'GET';
$url                 = Str::contains($url, url('/')) ? $url : url('/') . '/' . $url;
$expanded            = $expanded ?? false;
$accordion_title     = $accordion_title ?? trans('modular-forms::common.filters');
$submit_button_label = $submit_button_label ?? trans('modular-forms::common.apply_filters');

?>

<x-modular-forms::accordion.container class="form-filters">

    <x-modular-forms::accordion.item title="{{ mb_strtoupper($accordion_title) }}">

        <form class="form-horizontal" method="{{ $method }}" action="{{ $url }}">
            {{ csrf_field() }}

            <div class="form-grid">
                {{ $filter_content }}
            </div>

            <div class="text-right">
                <button type="submit" class="btn-nav rounded">{{ ucfirst($submit_button_label) }}</button>
            </div>

        </form>

    </x-modular-forms::accordion.item>

</x-modular-forms::accordion.container>
