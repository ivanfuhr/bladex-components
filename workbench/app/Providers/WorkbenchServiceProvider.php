<?php

declare(strict_types=1);

namespace Workbench\App\Providers;

use Illuminate\Support\ServiceProvider;
use Ivanfuhr\StdComponents\StdComponentsServiceProvider;
use Workbench\App\Playbook\PlaybookPreviewRenderer;
use Workbench\App\Playbook\PlaybookRegistry;
use Workbench\App\Playbook\PlaybookStateValidator;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->register(StdComponentsServiceProvider::class);

        $this->app->singleton(PlaybookRegistry::class);
        $this->app->singleton(PlaybookStateValidator::class);
        $this->app->singleton(PlaybookPreviewRenderer::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'workbench');
    }
}
