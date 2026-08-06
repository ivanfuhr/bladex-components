<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\Assets;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FrontendAssets
{
    public bool $hasRenderedScripts = false;

    public bool $hasRenderedStyles = false;

    public function boot(): void
    {
        Route::get(self::scriptPath(), [self::class, 'returnJavaScriptAsFile'])
            ->name('std-components.scripts');

        Route::get(self::stylePath(), [self::class, 'returnStylesheetAsFile'])
            ->name('std-components.styles');

        Blade::directive('stdScripts', static function (?string $expression = null) {
            $expression = $expression ?? '';

            return '<?php echo \\Ivanfuhr\\StdComponents\\Assets\\FrontendAssets::scripts('.$expression.'); ?>';
        });

        Blade::directive('stdStyles', static function (?string $expression = null) {
            $expression = $expression ?? '';

            return '<?php echo \\Ivanfuhr\\StdComponents\\Assets\\FrontendAssets::styles('.$expression.'); ?>';
        });
    }

    public static function scriptPath(): string
    {
        return '/std-components/std-components.js';
    }

    public static function stylePath(): string
    {
        return '/std-components/std-components.css';
    }

    public static function javaScriptPath(): string
    {
        return dirname(__DIR__, 2).'/resources/dist/std-components.js';
    }

    public static function stylesheetPath(): string
    {
        return dirname(__DIR__, 2).'/resources/css/std-components.css';
    }

    public static function returnJavaScriptAsFile(): BinaryFileResponse
    {
        return self::returnAssetAsFile(self::javaScriptPath(), 'application/javascript; charset=utf-8');
    }

    public static function returnStylesheetAsFile(): BinaryFileResponse
    {
        return self::returnAssetAsFile(self::stylesheetPath(), 'text/css; charset=utf-8');
    }

    public static function returnAssetAsFile(string $path, string $contentType): BinaryFileResponse
    {
        $lastModified = filemtime($path);
        $maxAge = 31536000;

        return response()->file($path, [
            'Content-Type' => $contentType,
            'Cache-Control' => 'public, max-age='.$maxAge,
            'Expires' => gmdate('D, d M Y H:i:s', time() + $maxAge).' GMT',
            'Last-Modified' => $lastModified !== false
                ? gmdate('D, d M Y H:i:s', $lastModified).' GMT'
                : gmdate('D, d M Y H:i:s').' GMT',
        ]);
    }

    /**
     * @param  array<string, mixed>  $options
     */
    public static function scripts(array $options = []): string
    {
        $instance = app(self::class);

        if ($instance->hasRenderedScripts) {
            return '';
        }

        $instance->hasRenderedScripts = true;

        $url = $options['url'] ?? static::scriptUrl();

        return sprintf(
            '<script src="%s?v=%s" defer></script>',
            e($url),
            e(static::scriptVersion()),
        );
    }

    /**
     * @param  array<string, mixed>  $options
     */
    public static function styles(array $options = []): string
    {
        $instance = app(self::class);

        if ($instance->hasRenderedStyles) {
            return '';
        }

        $instance->hasRenderedStyles = true;

        $url = $options['url'] ?? static::styleUrl();

        return sprintf(
            '<link rel="stylesheet" href="%s?v=%s" />',
            e($url),
            e(static::styleVersion()),
        );
    }

    public static function scriptVersion(): string
    {
        return static::hashFileAt(static::javaScriptPath());
    }

    public static function styleVersion(): string
    {
        return static::hashFileAt(static::stylesheetPath());
    }

    public static function hashFileAt(string $path): string
    {
        if (! is_file($path)) {
            return 'dev';
        }

        $hash = hash_file('sha256', $path);

        return $hash === false ? 'dev' : substr($hash, 0, 8);
    }

    public static function scriptUrl(): string
    {
        return url(self::scriptPath());
    }

    public static function styleUrl(): string
    {
        return url(self::stylePath());
    }
}
