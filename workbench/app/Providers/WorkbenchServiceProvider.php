<?php

declare(strict_types=1);

namespace Workbench\App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Ivanfuhr\Stencil\StencilServiceProvider;
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
        $this->app->register(StencilServiceProvider::class);

        $this->app->singleton(PlaybookRegistry::class);
        $this->app->singleton(PlaybookStateValidator::class);
        $this->app->singleton(PlaybookPreviewRenderer::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->ensurePlaybookStencilConfig();
        $this->ensurePlaybookIcons();

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'workbench');
    }

    /**
     * Keep a stable stencil.json for the playbook so Pest helpers that delete or
     * rewrite the file do not leave the workbench pointing at stub icon paths.
     */
    private function ensurePlaybookStencilConfig(): void
    {
        $path = $this->app->basePath('stencil.json');

        $desired = [
            'registry' => 'package://registry.json',
            'paths' => [
                'ui' => 'resources/views/ui',
                'icons' => 'resources/views/ui/icons',
            ],
        ];

        if (is_file($path)) {
            $current = json_decode((string) file_get_contents($path), true);

            if (is_array($current)) {
                $iconsPath = $current['paths']['icons'] ?? null;

                // Tests leave behind storage/framework/testing/... stub trees.
                if (is_string($iconsPath) && ! str_contains($iconsPath, 'storage/framework/testing')) {
                    return;
                }
            }
        }

        File::put(
            $path,
            json_encode($desired, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n",
        );
    }

    /**
     * Sync versioned Lucide stubs from the workbench into the Testbench app.
     */
    private function ensurePlaybookIcons(): void
    {
        $source = dirname(__DIR__, 2).'/resources/views/ui/icons';
        $target = $this->app->basePath('resources/views/ui/icons');

        if (! File::isDirectory($source)) {
            return;
        }

        File::ensureDirectoryExists($target);

        foreach (File::files($source) as $file) {
            $destination = $target.DIRECTORY_SEPARATOR.$file->getFilename();
            $sourceContents = File::get($file->getPathname());

            if (! is_file($destination) || $this->isStubIcon(File::get($destination))) {
                File::put($destination, $sourceContents);
            }
        }
    }

    private function isStubIcon(string $contents): bool
    {
        return str_contains($contents, '<path d="M12 2v20"/>')
            || str_contains($contents, '<path d="M12 2v20"/>');
    }
}
