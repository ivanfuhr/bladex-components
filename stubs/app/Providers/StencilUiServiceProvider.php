<?php

declare(strict_types=1);

namespace App\Providers;

use App\Support\Stencil\Button\ButtonClassMap;
use App\Support\Stencil\Form\FormControlClassMap;
use App\Support\Stencil\Interaction\InteractionStateAttributes;
use App\Support\Stencil\Interaction\InteractionStateClassMap;
use App\Support\Stencil\ProjectConfig;
use App\Support\Stencil\Typography\GoogleFontsStylesheetBuilder;
use App\Support\Stencil\Typography\TypographyClassMap;
use App\Support\Stencil\Typography\TypographyConfig;
use App\Support\Stencil\Typography\TypographyScale;
use App\View\Components\Ui\Field;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class StencilUiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (is_file(config_path('stencil-ui.php'))) {
            $this->mergeConfigFrom(config_path('stencil-ui.php'), 'stencil-ui');
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
        $this->loadTranslationsFrom(lang_path('stencil-ui'), 'stencil-ui');

        $uiPath = app(ProjectConfig::class)->resolvedUiPath();

        if (is_dir($uiPath)) {
            Blade::anonymousComponentPath($uiPath, 'ui');
        }

        Blade::component(Field::class, 'ui::field');
    }
}
