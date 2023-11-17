<?php
/** @var \AndreaMarelli\ModularForms\Controllers\FormController $controller */
/** @var \AndreaMarelli\ModularForms\Models\Form $item */

?>

<a href="{{ action([$controller, 'publish'], [$item->getKey()]) }}"
   target="_blank"
   class="btn-nav small"
   role="button"
    {!! AndreaMarelli\ModularForms\Helpers\Template::icon('eye', 'white') !!}
</a>
<tooltip>
    @uclang('modular-forms::common.show')
</tooltip>
