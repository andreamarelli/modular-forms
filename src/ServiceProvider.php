<?php

namespace AndreaMarelli\ModularForms;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvide;

class ServiceProvider extends BaseServiceProvide
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../src/Views', 'modular-forms');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

}
