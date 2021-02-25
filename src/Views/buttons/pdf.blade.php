<?php
/** @var \AndreaMarelli\ModularForms\Controllers\FormController $controller */
/** @var \AndreaMarelli\ModularForms\Models\Form $item */

?>

<a href="{{ action([$controller, 'pdf'], [$item->getKey()]) }}"
   target="_blank"
   class="btn btn-danger btn-sm"
   role="button"
   data-toggle="tooltip" data-placement="top" data-original-title="@lang('common.pdf')">
    {!! AndreaMarelli\ModularForms\Helpers\Template::icon('file-pdf', 'white') !!}
</a>
