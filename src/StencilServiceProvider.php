<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Ivanfuhr\Stencil\Console\Commands\AddCommand;
use Ivanfuhr\Stencil\Console\Commands\IconCommand;
use Ivanfuhr\Stencil\Console\Commands\InitCommand;
use Ivanfuhr\Stencil\Console\Commands\ListCommand;
use Ivanfuhr\Stencil\Console\Commands\RemoveCommand;
use Ivanfuhr\Stencil\Console\Commands\UpdateCommand;
use Ivanfuhr\Stencil\Registry\ComponentInstaller;
use Ivanfuhr\Stencil\Registry\OwnedArtifactCompiler;
use Ivanfuhr\Stencil\Registry\ProjectIntegrator;
use Ivanfuhr\Stencil\Registry\ProjectScaffolder;
use Ivanfuhr\Stencil\Registry\RegistryClient;
use Ivanfuhr\Stencil\Registry\RegistryResolver;
use Ivanfuhr\Stencil\Support\Button\ButtonClassMap;
use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;
use Ivanfuhr\Stencil\Support\Interaction\InteractionStateClassMap;
use Ivanfuhr\Stencil\Support\ProjectConfig;
use Ivanfuhr\Stencil\Support\ProjectLock;
use Ivanfuhr\Stencil\Support\Tailwind\TailwindIntegrationValidator;
use Ivanfuhr\Stencil\Support\Typography\GoogleFontsStylesheetBuilder;
use Ivanfuhr\Stencil\Support\Typography\TypographyClassMap;
use Ivanfuhr\Stencil\Support\Typography\TypographyConfig;
use Ivanfuhr\Stencil\Support\Typography\TypographyScale;
use Throwable;

class StencilServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/stencil.php', 'stencil');

        $this->app->singleton(Stencil::class);

        $this->app->bind(ProjectConfig::class, fn (Application $app) => new ProjectConfig($app));
        $this->app->bind(ProjectLock::class, fn (Application $app) => new ProjectLock($app));
        $this->app->singleton(RegistryClient::class, function (Application $app): RegistryClient {
            $configuredPath = config('stencil.package_registry_path');

            $packageRegistryPath = is_string($configuredPath) && $configuredPath !== ''
                ? $configuredPath
                : dirname(__DIR__).'/registry';

            return new RegistryClient($packageRegistryPath);
        });
        $this->app->singleton(RegistryResolver::class);
        $this->app->singleton(ComponentInstaller::class);
        $this->app->singleton(OwnedArtifactCompiler::class);
        $this->app->singleton(ProjectIntegrator::class);
        $this->app->singleton(ProjectScaffolder::class);

        $this->app->singleton(TypographyConfig::class);
        $this->app->singleton(TypographyScale::class);
        $this->app->singleton(TypographyClassMap::class);
        $this->app->singleton(ButtonClassMap::class);
        $this->app->singleton(FormControlClassMap::class);
        $this->app->singleton(InteractionStateClassMap::class);
        $this->app->singleton(InteractionStateAttributes::class);
        $this->app->singleton(TailwindIntegrationValidator::class);
        $this->app->singleton(GoogleFontsStylesheetBuilder::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'stencil');

        Blade::anonymousComponentPath(
            __DIR__.'/../resources/views/components',
            'stencil',
        );

        $this->registerOwnedUiNamespace();

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'stencil');

        $this->ensureTailwindIntegrationInDebug();

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
            (string) config('stencil.default_ui_path', 'resources/views/ui'),
        );

        if (is_dir($defaultUiPath)) {
            try {
                Blade::anonymousComponentPath($defaultUiPath, 'ui');
            } catch (Throwable) {
                //
            }
        }
    }

    private function ensureTailwindIntegrationInDebug(): void
    {
        if (! config('app.debug')) {
            return;
        }

        if (! config('stencil.validate_tailwind_integration', true)) {
            return;
        }

        if ($this->app->runningInConsole()) {
            return;
        }

        if ($this->app->runningUnitTests()) {
            return;
        }

        $this->app->make(TailwindIntegrationValidator::class)->assertConfigured($this->app);
    }

    private function registerConsoleResources(): void
    {
        $this->publishes([
            __DIR__.'/../config/stencil.php' => config_path('stencil.php'),
        ], ['stencil', 'stencil-config']);

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/stencil'),
        ], ['stencil', 'stencil-views']);

        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/stencil'),
        ], ['stencil', 'stencil-lang']);

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/stencil'),
        ], ['stencil', 'stencil-assets']);

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
