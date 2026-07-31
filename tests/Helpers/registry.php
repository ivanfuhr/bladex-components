<?php

declare(strict_types=1);

use App\Providers\StencilUiServiceProvider;
use Composer\Autoload\ClassLoader;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Http;
use Ivanfuhr\Stencil\Support\ProjectConfig;

function registryFixturePath(string $relative): string
{
    return dirname(__DIR__).'/fixtures/registry/'.$relative;
}

function registryFixtureJson(string $relative): array
{
    $contents = file_get_contents(registryFixturePath($relative));

    if ($contents === false) {
        throw new RuntimeException("Missing registry fixture: {$relative}");
    }

    $data = json_decode($contents, true);

    if (! is_array($data)) {
        throw new RuntimeException("Invalid registry fixture: {$relative}");
    }

    return $data;
}

function fakeRegistryHttp(): void
{
    fakeLucideIconHttp();

    Http::fake(function (Request $request) {
        $url = $request->url();

        if (str_ends_with($url, '/registry.json')) {
            return Http::response(registryFixtureJson('registry.json'));
        }

        if (preg_match('#/items/([^/]+)\.json$#', $url, $matches) === 1) {
            return Http::response(registryFixtureJson('items/'.$matches[1].'.json'));
        }

        return Http::response('Not found', 404);
    });
}

function useRegistryProjectConfig(string $registryUrl = 'https://registry.test/registry.json'): void
{
    $config = [
        '$schema' => 'https://example.test/schema/stencil.json',
        'registry' => $registryUrl,
        'paths' => [
            'ui' => 'resources/views/ui',
        ],
    ];

    file_put_contents(
        app()->basePath('stencil.json'),
        json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n",
    );
}

function registerOwnedUiNamespace(): void
{
    Blade::anonymousComponentPath(
        app(ProjectConfig::class)->resolvedUiPath(),
        'ui',
    );
}

function bootOwnedStencilScaffold(): void
{
    static $autoloadRegistered = false;
    $appPath = app()->basePath('app');

    if (! $autoloadRegistered && is_dir($appPath)) {
        $loader = new ClassLoader;
        $loader->addPsr4('App\\', $appPath.DIRECTORY_SEPARATOR);
        $loader->register();
        $autoloadRegistered = true;
    }

    if (class_exists(StencilUiServiceProvider::class)) {
        app()->register(StencilUiServiceProvider::class);
    }
}

function useOwnedRegistryProject(string $registryUrl = 'https://registry.test/registry.json'): void
{
    Artisan::call('stencil:init');

    $path = app()->basePath('stencil.json');
    $config = json_decode((string) file_get_contents($path), true);
    $config['registry'] = $registryUrl;
    file_put_contents($path, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n");

    bootOwnedStencilScaffold();
}

function testbenchBasePath(): string
{
    return dirname(__DIR__, 2).'/vendor/orchestra/testbench-core/laravel';
}

function deleteDirectoryWithoutFacades(string $directory): void
{
    if (! is_dir($directory)) {
        return;
    }

    $items = scandir($directory);

    if ($items === false) {
        return;
    }

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }

        $path = $directory.DIRECTORY_SEPARATOR.$item;

        if (is_dir($path)) {
            deleteDirectoryWithoutFacades($path);
        } elseif (is_file($path)) {
            unlink($path);
        }
    }

    rmdir($directory);
}

function cleanupOwnedProjectArtifacts(?string $basePath = null): void
{
    $base = $basePath ?? app()->basePath();
    $langPath = $base.DIRECTORY_SEPARATOR.'lang';

    $paths = [
        $base.DIRECTORY_SEPARATOR.'stencil.json',
        $base.DIRECTORY_SEPARATOR.'stencil.lock',
        $base.DIRECTORY_SEPARATOR.'config/stencil-ui.php',
        $base.DIRECTORY_SEPARATOR.'resources/css/stencil.css',
        $base.DIRECTORY_SEPARATOR.'app/Providers/StencilUiServiceProvider.php',
        $langPath.DIRECTORY_SEPARATOR.'stencil-ui/en/messages.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    deleteDirectoryWithoutFacades($base.DIRECTORY_SEPARATOR.'resources/views/ui');
    deleteDirectoryWithoutFacades($base.DIRECTORY_SEPARATOR.'app/Support/Stencil');
    deleteDirectoryWithoutFacades($langPath.DIRECTORY_SEPARATOR.'stencil-ui');

    $providersPath = $base.DIRECTORY_SEPARATOR.'bootstrap/providers.php';

    if (file_exists($providersPath)) {
        file_put_contents($providersPath, "<?php\n\nreturn [\n    //\n];\n");
    }
}
