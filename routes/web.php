<?php

use AndreaMarelli\ModularForm\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('hello', [Controller::class, 'index']);
