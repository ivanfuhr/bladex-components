<?php

declare(strict_types=1);

namespace Ivanfuhr\BladexComponents;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Ivanfuhr\BladexComponents\Console\Commands\AddCommand;
use Ivanfuhr\BladexComponents\Console\Commands\IconCommand;
use Ivanfuhr\BladexComponents\Console\Commands\InitCommand;
use Ivanfuhr\BladexComponents\Console\Commands\ListCommand;
use Ivanfuhr\BladexComponents\Console\Commands\RemoveCommand;
use Ivanfuhr\BladexComponents\Console\Commands\UpdateCommand;
use Ivanfuhr\BladexComponents\Registry\ComponentInstaller;
use Ivanfuhr\BladexComponents\Registry\RegistryClient;
use Ivanfuhr\BladexComponents\Registry\RegistryResolver;
use Ivanfuhr\BladexComponents\Support\ProjectConfig;
use Ivanfuhr\BladexComponents\Support\ProjectLock;
use Ivanfuhr\BladexComponents\Support\Typography\GoogleFontsStylesheetBuilder;
use Ivanfuhr\BladexComponents\Support\Typography\TypographyClassMap;
use Ivanfuhr\BladexComponents\Support\Typography\TypographyConfig;
use Ivanfuhr\BladexComponents\Support\Typography\TypographyScale;
use Throwable;

class BladexComponentsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bladex-components.php', 'bladex-components');

        $this->app->singleton(BladexComponents::class);

        $this->app->bind(ProjectConfig::class, fn (Application $app) => new ProjectConfig($app));
        $this->app->bind(ProjectLock::class, fn (Application $app) => new ProjectLock($app));
        $this->app->singleton(RegistryClient::class, function (Application $app): RegistryClient {
            $configuredPath = config('bladex-components.package_registry_path');

            $packageRegistryPath = is_string($configuredPath) && $configuredPath !== ''
                ? $configuredPath
                : dirname(__DIR__).'/registry';

            return new RegistryClient($packageRegistryPath);
        });
        $this->app->singleton(RegistryResolver::class);
        $this->app->singleton(ComponentInstaller::class);

        $this->app->singleton(TypographyConfig::class);
        $this->app->singleton(TypographyScale::class);
        $this->app->singleton(TypographyClassMap::class);
        $this->app->singleton(GoogleFontsStylesheetBuilder::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'bladex-components');

        Blade::anonymousComponentPath(
            __DIR__.'/../resources/views/components',
            'bladex-components',
        );

        $this->registerOwnedUiNamespace();

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'bladex-components');

        if ($this->app->runningInConsole()) {
            $this->registerConsoleResources();
        }
    }

    private function registerOwnedUiNamespace(): void
    {
        $registered = false;

        $projectConfig = new ProjectConfig($this->app);

        if ($projectConfig->exists()) {
            try {
                Blade::anonymousComponentPath(
                    $projectConfig->resolvedUiPath(),
                    'ui',
                );

                $registered = true;
            } catch (Throwable) {
                //
            }
        }

        if ($registered) {
            return;
        }

        $defaultUiPath = $this->app->basePath(
            (string) config('bladex-components.default_ui_path', 'resources/views/ui'),
        );

        if (is_dir($defaultUiPath)) {
            try {
                Blade::anonymousComponentPath($defaultUiPath, 'ui');
            } catch (Throwable) {
                //
            }
        }
    }

    private function registerConsoleResources(): void
    {
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
            InitCommand::class,
            AddCommand::class,
            UpdateCommand::class,
            RemoveCommand::class,
            ListCommand::class,
            IconCommand::class,
        ]);
    }
}
