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
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'modular-forms');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../src/Views', 'modular-forms');
        $this->publishes([__DIR__.'/../src/Views' => resource_path('views/vendor/modular-forms')]);
        $this->loadRoutesFrom(__DIR__.'/../src/Routes/web.php');
        $this->publishes([__DIR__.'/../config/config.php' => config_path('modular-forms.php')]);
    }

}
