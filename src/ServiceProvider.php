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
        // Views
        $this->loadViewsFrom(__DIR__.'/../views', 'modular-forms');
        // Routes
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }


    /**
     * Route configuration (eventually from config file)
     *
     * @return string[]
     */
    protected function routeConfiguration()
    {
        return [
            'prefix' => 'modular-forms',
            //'middleware' => config('modular-forms.middleware'),
        ];
    }

}
