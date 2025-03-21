<?php

namespace ModularForms;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;


class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Components
        Blade::componentNamespace('ModularForms\\View', 'modular-forms');

        // Views
        $this->loadViewsFrom(__DIR__.'/resources/views', 'modular-forms');

        // Routes
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');

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
