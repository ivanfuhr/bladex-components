<?php

declare(strict_types=1);

namespace Ivanfuhr\BladexComponents\Support\Tailwind;

use Illuminate\Contracts\Foundation\Application;
use RuntimeException;

final class TailwindIntegrationValidator
{
    /** @var list<string> */
    private const array INTEGRATION_MARKERS = [
        'bladex-components/resources/tailwind/bladex.css',
        'resources/tailwind/bladex.css',
        'bladex-components/src/Support',
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
        return <<<'TEXT'
BladeX Components: Tailwind CSS is not configured to scan package class maps.

Button and other primitives resolve utilities from PHP under vendor/ivanfuhr/bladex-components/src/Support. Without Tailwind sources, variant styles (for example bg-zinc-900 on variant="primary") are missing from your compiled CSS.

Fix (Tailwind v4) — add to your app stylesheet (adjust the vendor path):

    @import "tailwindcss";
    @import "../../vendor/ivanfuhr/bladex-components/resources/tailwind/bladex.css";

Fix (Tailwind v3) — add to tailwind.config.js content:

    './vendor/ivanfuhr/bladex-components/resources/views/**/*.blade.php',
    './vendor/ivanfuhr/bladex-components/src/Support/**/*.php',

Then rebuild assets (npm run dev / npm run build).

To disable this check in local debug: set bladex-components.validate_tailwind_integration to false in config.
TEXT;
    }
}
