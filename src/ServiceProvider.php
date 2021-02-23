<?php

namespace AndreaMarelli\ModularForms;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;


class ServiceProvider extends BaseServiceProvider
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
        $this->loadRoutesFrom(__DIR__.'/../src/Routes/web.php');
    }

}
