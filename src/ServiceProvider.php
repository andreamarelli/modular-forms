<?php

namespace AndreaMarelli\ModularForms;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;


class ServiceProvider extends BaseServiceProvider
{
    const BASE_PATH = __DIR__ . '/../';

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(static::BASE_PATH . 'config/config.php', 'imet-core');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Components
        Blade::componentNamespace('AndreaMarelli\\ModularForms\\View', 'modular-forms');

        // Views
        $this->loadViewsFrom(__DIR__.'/resources/views', 'modular-forms');

        // Routes
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');

        // Config
        $this->publishes([
            static::BASE_PATH . 'config/config.php' => config_path('modular-forms.php')
        ], 'modular-forms');

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
