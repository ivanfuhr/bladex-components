<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Ivanfuhr\StdComponents\Assets\FrontendAssets;

it('compiles stdScripts directive', function () {
    $compiled = Blade::compileString('@stdScripts');

    expect($compiled)->toContain('FrontendAssets::scripts');
});

it('compiles stdStyles directive', function () {
    $compiled = Blade::compileString('@stdStyles');

    expect($compiled)->toContain('FrontendAssets::styles');
});

it('renders script tag once per request', function () {
    $first = FrontendAssets::scripts();
    $second = FrontendAssets::scripts();

    expect($first)
        ->toContain('<script')
        ->toContain('/std-components/std-components.js')
        ->and($second)->toBe('');
});

it('renders stylesheet link once per request', function () {
    app()->forgetInstance(FrontendAssets::class);

    $first = FrontendAssets::styles();
    $second = FrontendAssets::styles();

    expect($first)
        ->toContain('<link')
        ->toContain('/std-components/std-components.css')
        ->and($second)->toBe('');
});

it('serves std-components javascript route', function () {
    $response = $this->get('/std-components/std-components.js');

    $response->assertOk();
    $response->assertHeader('content-type', 'application/javascript; charset=utf-8');
});

it('serves std-components stylesheet route', function () {
    $response = $this->get('/std-components/std-components.css');

    $response->assertOk();
    $response->assertHeader('content-type', 'text/css; charset=utf-8');
});
