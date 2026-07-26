<?php

declare(strict_types=1);

namespace Ivanfuhr\BladexComponents;

use Illuminate\Support\ServiceProvider;
use Ivanfuhr\BladexComponents\Console\Commands\BladexComponentsCommand;

class BladexComponentsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bladex-components.php', 'bladex-components');

        $this->app->singleton(BladexComponents::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'bladex-components');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'bladex-components');

        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/bladex-components.php' => config_path('bladex-components.php'),
        ], ['bladex-components', 'bladex-components-config']);

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/bladex-components'),
        ], ['bladex-components', 'bladex-components-views']);

        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/bladex-components'),
        ], ['bladex-components', 'bladex-components-lang']);

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/bladex-components'),
        ], ['bladex-components', 'bladex-components-assets']);

        $this->commands([
            BladexComponentsCommand::class,
        ]);
    }
}
