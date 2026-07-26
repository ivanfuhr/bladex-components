<?php

declare(strict_types=1);

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Blade;
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
