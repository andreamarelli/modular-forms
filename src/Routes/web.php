<?php

use AndreaMarelli\ModularForms\controllers\Controller;
use AndreaMarelli\ModularForms\Helpers\Locale;
use Illuminate\Support\Facades\Route;

define('UPPER_LOCALE', Locale::upper());
define('LOWER_LOCALE', Locale::lower());


Route::get('hello', [Controller::class, 'hello']);
