<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Ivanfuhr\StdComponents\Assets\FrontendAssets;
use Ivanfuhr\StdComponents\Console\Commands\IconCommand;
use Ivanfuhr\StdComponents\Support\Button\ButtonClassMap;
use Ivanfuhr\StdComponents\Support\Icon\IconPathResolver;
use Ivanfuhr\StdComponents\Support\Icon\LucideIconInstaller;
use Ivanfuhr\StdComponents\Support\Icon\LucideIconStubGenerator;
use Ivanfuhr\StdComponents\Support\Interaction\InteractionStateAttributes;
use Ivanfuhr\StdComponents\Support\Interaction\InteractionStateClassMap;
use Ivanfuhr\StdComponents\Support\Typography\TypographyClassMap;
use Ivanfuhr\StdComponents\View\Components\Breadcrumb\ListView;
use Ivanfuhr\StdComponents\View\Components\EmptyState;
use Ivanfuhr\StdComponents\View\Components\SwitchControl;

class StdComponentsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/std-components.php', 'std-components');

        $this->app->singleton(StdComponents::class);
        $this->app->singleton(FrontendAssets::class);
        $this->app->singleton(TypographyClassMap::class);
        $this->app->singleton(InteractionStateClassMap::class);
        $this->app->singleton(InteractionStateAttributes::class);
        $this->app->singleton(ButtonClassMap::class);
        $this->app->singleton(LucideIconStubGenerator::class);
        $this->app->singleton(IconPathResolver::class);
        $this->app->singleton(LucideIconInstaller::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadStdHelpers();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'std-components');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'std');

        Blade::componentNamespace('Ivanfuhr\\StdComponents\\View\\Components', 'std');

        Blade::anonymousComponentPath(__DIR__.'/../resources/views/icons', 'icons');

        $this->registerReservedComponentAliases();

        $this->app->make(FrontendAssets::class)->boot();

        if ($this->app->runningInConsole()) {
            $this->registerConsoleResources();
        }
    }

    private function loadStdHelpers(): void
    {
        $packageHelpers = dirname(__DIR__).'/resources/views/std/helpers.php';

        if (is_file($packageHelpers)) {
            require_once $packageHelpers;
        }
    }

    private function registerReservedComponentAliases(): void
    {
        // Reserved words (`list`, `empty`, `switch`) cannot be used as PHP
        // class names, so the alias must be registered against the full `std::`
        // tag name directly — the `$prefix` argument produces a dash-joined
        // alias that never matches the `namespace::segment` lookup key used
        // for tags like `<x-std::stepper.list>` or `<x-std::switch>`.
        $namespacedAliases = [
            EmptyState::class => 'empty',
            ListView::class => 'breadcrumb.list',
            SwitchControl::class => 'switch',
            View\Components\Combobox\EmptyState::class => 'combobox.empty',
            View\Components\Command\EmptyState::class => 'command.empty',
            View\Components\Command\ListView::class => 'command.list',
            View\Components\FileUpload\ListView::class => 'file-upload.list',
            View\Components\Stepper\ListView::class => 'stepper.list',
            View\Components\Tabs\ListView::class => 'tabs.list',
        ];

        foreach ($namespacedAliases as $class => $alias) {
            Blade::component($class, 'std::'.$alias);
        }
    }

    private function registerConsoleResources(): void
    {
        $this->publishes([
            __DIR__.'/../config/std-components.php' => config_path('std-components.php'),
        ], ['std-components', 'std-components-config']);

        $this->publishes([
            __DIR__.'/../resources/dist' => public_path('vendor/std-components'),
            __DIR__.'/../resources/css/std-components.css' => public_path('vendor/std-components/std-components.css'),
        ], ['std-components', 'std-components-assets']);

        $this->commands([
            IconCommand::class,
        ]);
    }
}
