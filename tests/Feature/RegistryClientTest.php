<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Ivanfuhr\Stencil\Registry\RegistryClient;

it('reads the registry index from the package when using package protocol', function () {
    $client = app(RegistryClient::class);

    $index = $client->fetchIndex('package://registry.json');

    expect($index['name'])->toBe('ivanfuhr/stencil');
    expect(collect($index['items'])->pluck('name')->all())->toContain('input', 'input-group');
});

it('falls back to the package registry when a remote index returns 404', function () {
    Http::fake([
        'https://example.test/*' => Http::response('Not found', 404),
    ]);

    $client = app(RegistryClient::class);

    $index = $client->fetchIndex('https://example.test/registry/registry.json');

    expect($index['name'])->toBe('ivanfuhr/stencil');
});

it('merges package registry items that are missing from a remote index', function () {
    Http::fake([
        'https://example.test/registry/registry.json' => Http::response([
            'name' => 'remote-registry',
            'items' => [
                ['name' => 'input-group', 'title' => 'Input Group'],
                ['name' => 'input', 'title' => 'Input'],
                ['name' => 'text', 'title' => 'Text'],
                ['name' => 'heading', 'title' => 'Heading'],
                ['name' => 'button', 'title' => 'Button'],
            ],
        ]),
    ]);

    $client = app(RegistryClient::class);

    $index = $client->fetchIndex('https://example.test/registry/registry.json');

    expect($index['name'])->toBe('remote-registry');
    expect(collect($index['items'])->pluck('name')->all())->toContain('select');
});
