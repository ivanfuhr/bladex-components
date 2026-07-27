<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Support\Tailwind;

use Illuminate\Contracts\Foundation\Application;
use Ivanfuhr\Stencil\Registry\ProjectIntegrator;
use RuntimeException;

final class TailwindIntegrationValidator
{
    /** @var list<string> */
    private const array INTEGRATION_MARKERS = [
        'resources/css/stencil.css',
        'stencil-start',
        'app/Support/Stencil',
    ];

    public function assertConfigured(Application $app): void
    {
        if ($this->isConfigured($app)) {
            return;
        }

        throw new RuntimeException($this->explanation());
    }

    public function isConfigured(Application $app): bool
    {
        if (is_file($app->basePath('resources/css/stencil.css'))) {
            return true;
        }

        foreach ($this->candidateFiles($app) as $path) {
            $contents = @file_get_contents($path);

            if (! is_string($contents) || $contents === '') {
                continue;
            }

            if ($this->contentsIndicateIntegration($contents)) {
                return true;
            }
        }

        return false;
    }

    public function contentsIndicateIntegration(string $contents): bool
    {
        foreach (self::INTEGRATION_MARKERS as $marker) {
            if (str_contains($contents, $marker)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return list<string>
     */
    private function candidateFiles(Application $app): array
    {
        $base = $app->basePath();

        $paths = [
            $base.'/resources/css/app.css',
            $base.'/resources/css/app.scss',
            $base.'/resources/sass/app.scss',
            $base.'/tailwind.config.js',
            $base.'/tailwind.config.ts',
            $base.'/tailwind.config.mjs',
            $base.'/tailwind.config.cjs',
            $base.'/vite.config.js',
            $base.'/vite.config.ts',
            $base.'/vite.config.mjs',
        ];

        if (\function_exists('Orchestra\Testbench\workbench_path')) {
            $paths = array_merge($paths, [
                \Orchestra\Testbench\workbench_path('resources/css/app.css'),
                \Orchestra\Testbench\workbench_path('resources/css/app.scss'),
                \Orchestra\Testbench\workbench_path('vite.config.js'),
                \Orchestra\Testbench\workbench_path('vite.config.ts'),
                \Orchestra\Testbench\workbench_path('vite.config.mjs'),
            ]);
        }

        return array_values(array_filter($paths, static fn (string $path): bool => is_file($path)));
    }

    private function explanation(): string
    {
        $start = ProjectIntegrator::CSS_START;
        $end = ProjectIntegrator::CSS_END;

        return <<<TEXT
Stencil: owned Tailwind integration is missing.

Run stencil:init (once) and stencil:add for the components you use. That scaffolds resources/css/stencil.css and patches your app stylesheet.

If resources/css/app.css exists, add:

    {$start}
    @import "./stencil.css";
    {$end}

Then rebuild assets (npm run dev / npm run build).

To disable this check in local debug: set stencil.validate_tailwind_integration to false in config.
TEXT;
    }
}
