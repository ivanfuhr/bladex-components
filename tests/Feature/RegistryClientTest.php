<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Ivanfuhr\BladexComponents\Registry\RegistryClient;

it('reads the registry index from the package when using package protocol', function () {
    $client = app(RegistryClient::class);

    $index = $client->fetchIndex('package://registry.json');

    expect($index['name'])->toBe('ivanfuhr/bladex-components');
    expect(collect($index['items'])->pluck('name')->all())->toContain('input', 'input-group');
});

it('falls back to the package registry when a remote index returns 404', function () {
    Http::fake([
        'https://example.test/*' => Http::response('Not found', 404),
    ]);

    $client = app(RegistryClient::class);

    $index = $client->fetchIndex('https://example.test/registry/registry.json');

    expect($index['name'])->toBe('ivanfuhr/bladex-components');
});
