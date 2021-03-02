<?php
/**  This is a simple wrapper which allows it to be extended with custom type  */

/** @var String $type */
/** @var String $value */
/** @var bool $only_label [optional] */

$only_label = $only_label ?? false;


@include('modular-forms::module.show.field-value', [
   'type' => $type,
   'value' => $value,
   'only_label' => $only_label
])

