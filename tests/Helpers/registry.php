<?php

declare(strict_types=1);

use App\Providers\BladexUiServiceProvider;
use Composer\Autoload\ClassLoader;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Ivanfuhr\BladexComponents\Support\ProjectConfig;

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
        '$schema' => 'https://example.test/schema/bladex-components.json',
        'registry' => $registryUrl,
        'paths' => [
            'ui' => 'resources/views/ui',
        ],
    ];

    file_put_contents(
        app()->basePath('bladex-components.json'),
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

function bootOwnedBladexScaffold(): void
{
    static $autoloadRegistered = false;
    $appPath = app()->basePath('app');

    if (! $autoloadRegistered && is_dir($appPath)) {
        $loader = new ClassLoader;
        $loader->addPsr4('App\\', $appPath.DIRECTORY_SEPARATOR);
        $loader->register();
        $autoloadRegistered = true;
    }

    if (class_exists(BladexUiServiceProvider::class)) {
        app()->register(BladexUiServiceProvider::class);
    }
}

function useOwnedRegistryProject(string $registryUrl = 'https://registry.test/registry.json'): void
{
    Artisan::call('bladex-components:init');

    $path = app()->basePath('bladex-components.json');
    $config = json_decode((string) file_get_contents($path), true);
    $config['registry'] = $registryUrl;
    file_put_contents($path, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n");

    bootOwnedBladexScaffold();
}

function cleanupOwnedProjectArtifacts(): void
{
    $paths = [
        app()->basePath('bladex-components.json'),
        app()->basePath('bladex-components.lock'),
        app()->basePath('config/bladex-ui.php'),
        app()->basePath('resources/css/bladex.css'),
        app()->basePath('app/Providers/BladexUiServiceProvider.php'),
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    File::deleteDirectory(app()->resourcePath('views/ui'));
    File::deleteDirectory(app()->basePath('app/Support/Bladex'));

    $providersPath = app()->basePath('bootstrap/providers.php');

    if (file_exists($providersPath)) {
        file_put_contents($providersPath, "<?php\n\nreturn [\n    //\n];\n");
    }
}
