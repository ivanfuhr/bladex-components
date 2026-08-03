<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Ivanfuhr\Stencil\Assets\FrontendAssets;

it('compiles stencilScripts directive', function () {
    $compiled = Blade::compileString('@stencilScripts');

    expect($compiled)->toContain('FrontendAssets::scripts');
});

it('compiles stencilStyles directive', function () {
    $compiled = Blade::compileString('@stencilStyles');

    expect($compiled)->toContain('FrontendAssets::styles');
});

it('renders script tag once per request', function () {
    $first = FrontendAssets::scripts();
    $second = FrontendAssets::scripts();

    expect($first)
        ->toContain('<script')
        ->toContain('/stencil/stencil.js')
        ->and($second)->toBe('');
});

it('renders stylesheet link once per request', function () {
    app()->forgetInstance(FrontendAssets::class);

    $first = FrontendAssets::styles();
    $second = FrontendAssets::styles();

    expect($first)
        ->toContain('<link')
        ->toContain('/stencil/stencil.css')
        ->and($second)->toBe('');
});

it('serves stencil javascript route', function () {
    $response = $this->get('/stencil/stencil.js');

    $response->assertOk();
    $response->assertHeader('content-type', 'application/javascript; charset=utf-8');
});

it('serves stencil stylesheet route', function () {
    $response = $this->get('/stencil/stencil.css');

    $response->assertOk();
    $response->assertHeader('content-type', 'text/css; charset=utf-8');
});
