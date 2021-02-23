<?php

use AndreaMarelli\ModularForms\controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('hello', [Controller::class, 'hello']);
