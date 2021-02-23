<?php

use AndreaMarelli\ModularForm\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('hello', [Controller::class, 'hello']);
