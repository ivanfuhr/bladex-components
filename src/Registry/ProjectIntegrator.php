<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Registry;

use Ivanfuhr\Stencil\Support\ProjectConfig;
use Ivanfuhr\Stencil\Support\ProjectLock;
use RuntimeException;

final class ProjectIntegrator
{
    public const string CSS_START = '/* stencil-start */';

    public const string CSS_END = '/* stencil-end */';

    public const string JS_START = '// stencil-start';

    public const string JS_END = '// stencil-end';

    /** @var array<string, string> */
    private const array JAVASCRIPT_COMPONENTS = [
        'select' => 'select/select.js',
        'combobox' => 'combobox/combobox.js',
        'file-upload' => 'file-upload/file-upload.js',
        'input-otp' => 'input-otp/input-otp.js',
        'slider' => 'slider/slider.js',
        'dialog' => 'dialog/dialog.js',
        'calendar' => 'calendar/calendar.js',
        'date-picker' => 'date-picker/date-picker.js',
        'time-picker' => 'time-picker/time-picker.js',
        'datetime-picker' => 'datetime-picker/datetime-picker.js',
        'input-currency' => 'input/input-currency.js',
        'input' => 'input/input-enhancements.js',
        'repeater' => 'repeater/repeater.js',
        'pillbox' => 'pillbox/pillbox.js',
        'rating' => 'rating/rating.js',
        'color-picker' => 'color-picker/color-picker.js',
        'textarea' => 'textarea/textarea.js',
    ];

    public function ensureTailwind(ProjectConfig $config): void
    {
        $stencilCssRelative = 'resources/css/stencil.css';
        $stencilCssPath = $config->basePath($stencilCssRelative);

        if (! is_file($stencilCssPath)) {
            $stub = dirname(__DIR__, 2).'/stubs/resources/css/stencil.css';

            if (! is_file($stub)) {
                throw new RuntimeException('Missing stencil.css stub. Run composer registry:build.');
            }

            $directory = dirname($stencilCssPath);

            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            copy($stub, $stencilCssPath);
        }

        foreach ($this->stylesheetCandidates($config) as $stylesheet) {
            $this->patchStylesheetImport($stylesheet);
        }
    }

    public function syncFromLock(ProjectConfig $config, ProjectLock $lock): void
    {
        $this->ensureTailwind($config);
        $this->syncJavascriptImports($config, $lock->installedNames());
    }

    /**
     * @param  list<string>  $installedNames
     */
    private function syncJavascriptImports(ProjectConfig $config, array $installedNames): void
    {
        foreach ($this->javascriptEntryCandidates($config) as $entry) {
            $importPaths = [];

            foreach (self::JAVASCRIPT_COMPONENTS as $component => $relativeScript) {
                if (! in_array($component, $installedNames, true)) {
                    continue;
                }

                $scriptPath = $this->uiScriptPathForEntry($config, $entry, $relativeScript);
                $importPaths[] = $this->relativeImportPath(dirname($entry), $scriptPath);
            }

            if ($importPaths === []) {
                $this->removeMarkedBlock($entry);

                continue;
            }

            $this->patchJavascriptImports($entry, $importPaths);
        }
    }

    /**
     * @return list<string>
     */
    private function stylesheetCandidates(ProjectConfig $config): array
    {
        $base = $config->basePath();
        $paths = [
            $base.'/resources/css/app.css',
            $base.'/resources/css/app.scss',
            $base.'/resources/sass/app.scss',
        ];

        if (\function_exists('Orchestra\Testbench\workbench_path')) {
            $paths[] = \Orchestra\Testbench\workbench_path('resources/css/app.css');
            $paths[] = \Orchestra\Testbench\workbench_path('resources/css/app.scss');
        }

        return array_values(array_filter($paths, static fn (string $path): bool => is_file($path)));
    }

    /**
     * @return list<string>
     */
    private function javascriptEntryCandidates(ProjectConfig $config): array
    {
        $base = $config->basePath();
        $paths = [
            $base.'/resources/js/app.js',
            $base.'/resources/js/app.ts',
            $base.'/resources/js/app.mjs',
        ];

        if (\function_exists('Orchestra\Testbench\workbench_path')) {
            $paths[] = \Orchestra\Testbench\workbench_path('resources/js/app.js');
            $paths[] = \Orchestra\Testbench\workbench_path('resources/js/app.ts');
        }

        return array_values(array_filter($paths, static fn (string $path): bool => is_file($path)));
    }

    private function patchStylesheetImport(string $path): void
    {
        $contents = file_get_contents($path);

        if ($contents === false) {
            return;
        }

        if (str_contains($contents, self::CSS_START)) {
            return;
        }

        $block = self::CSS_START."\n@import \"./stencil.css\";\n".self::CSS_END."\n";
        $updated = rtrim($contents)."\n\n".$block;

        file_put_contents($path, $updated);
    }

    /**
     * @param  list<string>  $importPaths
     */
    private function patchJavascriptImports(string $path, array $importPaths): void
    {
        $contents = file_get_contents($path);

        if ($contents === false) {
            return;
        }

        $importLines = implode("\n", array_map(
            static fn (string $importPath): string => "import '{$importPath}';",
            $importPaths,
        ));

        $block = self::JS_START."\n".$importLines."\n".self::JS_END;

        if (str_contains($contents, self::JS_START)) {
            $pattern = '/'.preg_quote(self::JS_START, '/').'.*?'.preg_quote(self::JS_END, '/').'/s';
            $updated = preg_replace($pattern, $block, $contents);

            if (is_string($updated) && $updated !== $contents) {
                file_put_contents($path, $updated);
            }

            return;
        }

        $updated = rtrim($contents)."\n\n".$block."\n";

        file_put_contents($path, $updated);
    }

    private function uiScriptPathForEntry(ProjectConfig $config, string $entryPath, string $relativeScript): string
    {
        $uiRelative = $config->uiPath().'/'.$relativeScript;

        if (\function_exists('Orchestra\Testbench\workbench_path')) {
            $workbench = str_replace('\\', '/', \Orchestra\Testbench\workbench_path(''));
            $workbench = rtrim($workbench, '/');
            $normalizedEntry = str_replace('\\', '/', $entryPath);

            if (str_starts_with($normalizedEntry, $workbench.'/')) {
                return $workbench.'/'.ltrim(str_replace('\\', '/', $uiRelative), '/');
            }
        }

        return $config->basePath($uiRelative);
    }

    private function removeMarkedBlock(string $path): void
    {
        $contents = file_get_contents($path);

        if ($contents === false || ! str_contains($contents, self::JS_START)) {
            return;
        }

        $pattern = '/\s*'.preg_quote(self::JS_START, '/').'.*?'.preg_quote(self::JS_END, '/').'\s*/s';
        $updated = preg_replace($pattern, "\n", $contents);

        if (is_string($updated)) {
            file_put_contents($path, $updated);
        }
    }

    private function relativeImportPath(string $entryDirectory, string $targetFile): string
    {
        $normalize = static function (string $path): string {
            $path = str_replace('\\', '/', $path);
            $parts = [];

            foreach (explode('/', $path) as $segment) {
                if ($segment === '' || $segment === '.') {
                    continue;
                }

                if ($segment === '..') {
                    array_pop($parts);

                    continue;
                }

                $parts[] = $segment;
            }

            return implode('/', $parts);
        };

        $from = explode('/', $normalize($entryDirectory));
        $toDirectory = explode('/', $normalize(dirname($targetFile)));
        $fileName = basename($normalize($targetFile));

        while ($from !== [] && $toDirectory !== [] && $from[0] === $toDirectory[0]) {
            array_shift($from);
            array_shift($toDirectory);
        }

        $import = implode('/', [
            ...array_fill(0, count($from), '..'),
            ...$toDirectory,
            $fileName,
        ]);

        if (! str_contains($import, '/')) {
            return './'.$import;
        }

        return $import;
    }
}
