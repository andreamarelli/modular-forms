<?php
/** @var \AndreaMarelli\ModularForms\Controllers\Controller $controller */
/** @var String $label */

$label = $label ?? trans('common.create');

?>

<a href="{{ action([$controller, 'create']) }}"
   class="btn-nav rounded"> {!! AndreaMarelli\ModularForms\Helpers\Template::icon('plus-circle', 'white') !!} {{ ucfirst($label) }}
</a>
