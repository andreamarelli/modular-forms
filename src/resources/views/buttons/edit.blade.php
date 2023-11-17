<?php
/** @var \AndreaMarelli\ModularForms\Controllers\Controller $controller */
/** @var \Illuminate\Database\Eloquent\Model|String $item */

$href = $item instanceof \Illuminate\Database\Eloquent\Model
    ? 'href="' . action([$controller, 'edit'], [$item->getKey()]) . '"'
    : ':href="\'' . vueAction($controller, 'edit', $item ?? 'item.id') . '\'"';

?>
<a
        {!! $href !!}
        class="btn-nav yellow small"
        role="button">
    {!! AndreaMarelli\ModularForms\Helpers\Template::icon('pen', 'white') !!}
</a>
<tooltip>
    @uclang('modular-forms::common.edit')
</tooltip>