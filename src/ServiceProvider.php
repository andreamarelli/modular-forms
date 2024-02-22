<?php

namespace AndreaMarelli\ModularForms;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;


class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'modular-forms');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Components
        Blade::componentNamespace('AndreaMarelli\\ModularForms\\View', 'modular-forms');

        // Assets
        $this->publishes([__DIR__.'/../dist' => public_path('vendor/modular-forms')], ['modular-form', 'laravel-assets']);

        // Views
        $this->loadViewsFrom(__DIR__.'/resources/views', 'modular-forms');
        $this->publishes([__DIR__.'/resources/views' => resource_path('views/vendor/modular-forms')], 'views');

        // Routes
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');

        // Config
        $this->publishes([__DIR__.'/../config/config.php' => config_path('modular-forms.php')], 'config');

        //Lang
        $this->loadTranslationsFrom(__DIR__.'/Lang', 'modular-forms');

        // Custom blades
        Blade::directive('lang_u', function ($key) {
            return "<?php echo ucfirst(trans($key)); ?>";
        });
        Blade::directive('uclang', function ($key) {
            return "<?php echo ucfirst(trans($key)); ?>";
        });
    }

}
