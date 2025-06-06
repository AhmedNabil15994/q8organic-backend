<?php

namespace Modules\Order\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Order\Console\UpdatFailedQtyOrdersCommand;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerCommands();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Order', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }


    private function registerCommands()
    {
        $this->commands([
            UpdatFailedQtyOrdersCommand::class,
        ]);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('Order', 'Config/config.php') => config_path('order.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Order', 'Config/config.php'), 'order'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/order');

        $sourcePath = module_path('Order', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/order';
        }, \Config::get('view.paths')), [$sourcePath]), 'order');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/order');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'order');
        } else {
            $this->loadTranslationsFrom(module_path('Order', 'Resources/lang'), 'order');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            $this->loadFactoriesFrom(module_path('Order', 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
