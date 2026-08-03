<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Ivanfuhr\Stencil\Assets\FrontendAssets;
use Ivanfuhr\Stencil\Console\Commands\IconCommand;
use Ivanfuhr\Stencil\Support\Button\ButtonClassMap;
use Ivanfuhr\Stencil\Support\Icon\IconPathResolver;
use Ivanfuhr\Stencil\Support\Icon\LucideIconInstaller;
use Ivanfuhr\Stencil\Support\Icon\LucideIconStubGenerator;
use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;
use Ivanfuhr\Stencil\Support\Interaction\InteractionStateClassMap;
use Ivanfuhr\Stencil\Support\Typography\TypographyClassMap;
use Ivanfuhr\Stencil\View\Components\Breadcrumb\ListView;
use Ivanfuhr\Stencil\View\Components\EmptyState;
use Ivanfuhr\Stencil\View\Components\SwitchControl;

class StencilServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/stencil.php', 'stencil');

        $this->app->singleton(Stencil::class);
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
        $this->loadStencilHelpers();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'stencil');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ui');

        Blade::componentNamespace('Ivanfuhr\\Stencil\\View\\Components', 'ui');

        Blade::anonymousComponentPath(__DIR__.'/../resources/views/icons', 'icons');

        $this->registerReservedComponentAliases();

        $this->app->make(FrontendAssets::class)->boot();

        if ($this->app->runningInConsole()) {
            $this->registerConsoleResources();
        }
    }

    private function loadStencilHelpers(): void
    {
        $packageHelpers = dirname(__DIR__).'/resources/views/ui/helpers.php';

        if (is_file($packageHelpers)) {
            require_once $packageHelpers;
        }
    }

    private function registerReservedComponentAliases(): void
    {
        // Reserved words (`list`, `empty`, `switch`) cannot be used as PHP
        // class names, so the alias must be registered against the full `ui::`
        // tag name directly — the `$prefix` argument produces a dash-joined
        // alias that never matches the `namespace::segment` lookup key used
        // for tags like `<x-ui::stepper.list>` or `<x-ui::switch>`.
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
            Blade::component($class, 'ui::'.$alias);
        }
    }

    private function registerConsoleResources(): void
    {
        $this->publishes([
            __DIR__.'/../config/stencil.php' => config_path('stencil.php'),
        ], ['stencil', 'stencil-config']);

        $this->publishes([
            __DIR__.'/../resources/dist' => public_path('vendor/stencil'),
            __DIR__.'/../resources/css/stencil.css' => public_path('vendor/stencil/stencil.css'),
        ], ['stencil', 'stencil-assets']);

        $this->commands([
            IconCommand::class,
        ]);
    }
}
