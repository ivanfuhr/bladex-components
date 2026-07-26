<?php

declare(strict_types=1);

namespace App\Providers;

use App\Support\Bladex\Button\ButtonClassMap;
use App\Support\Bladex\Form\FormControlClassMap;
use App\Support\Bladex\Interaction\InteractionStateAttributes;
use App\Support\Bladex\Interaction\InteractionStateClassMap;
use App\Support\Bladex\ProjectConfig;
use App\Support\Bladex\Typography\GoogleFontsStylesheetBuilder;
use App\Support\Bladex\Typography\TypographyClassMap;
use App\Support\Bladex\Typography\TypographyConfig;
use App\Support\Bladex\Typography\TypographyScale;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladexUiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (is_file(config_path('bladex-ui.php'))) {
            $this->mergeConfigFrom(config_path('bladex-ui.php'), 'bladex-ui');
        }

        $this->app->bind(ProjectConfig::class, fn ($app) => new ProjectConfig($app));
        $this->app->singleton(TypographyConfig::class);
        $this->app->singleton(TypographyScale::class);
        $this->app->singleton(TypographyClassMap::class);
        $this->app->singleton(ButtonClassMap::class);
        $this->app->singleton(FormControlClassMap::class);
        $this->app->singleton(InteractionStateClassMap::class);
        $this->app->singleton(InteractionStateAttributes::class);
        $this->app->singleton(GoogleFontsStylesheetBuilder::class);
    }

    public function boot(): void
    {
        $uiPath = app(ProjectConfig::class)->resolvedUiPath();

        if (is_dir($uiPath)) {
            Blade::anonymousComponentPath($uiPath, 'ui');
        }
    }
}
