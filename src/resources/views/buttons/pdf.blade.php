<?php
/** @var \AndreaMarelli\ModularForms\Controllers\FormController $controller */
/** @var \AndreaMarelli\ModularForms\Models\Form $item */

?>

<a href="{{ action([$controller, 'pdf'], [$item->getKey()]) }}"
   target="_blank"
   class="btn-nav small red"
   role="button">
    {!! AndreaMarelli\ModularForms\Helpers\Template::icon('file-pdf', 'white') !!}
</a>
<tooltip>
    @uclang('modular-forms::common.pdf')
</tooltip>
