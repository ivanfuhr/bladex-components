<?php

declare(strict_types=1);

use Ivanfuhr\Stencil\Support\Tailwind\TailwindIntegrationValidator;

it('detects owned stencil tailwind markers in app stylesheets', function (): void {
    $validator = new TailwindIntegrationValidator;

    $css = '@import "tailwindcss"; /* stencil-start */ @import "./stencil.css"; /* stencil-end */';

    expect($validator->contentsIndicateIntegration($css))->toBeTrue();
});

it('detects resources/css/stencil.css marker text', function (): void {
    $validator = new TailwindIntegrationValidator;

    expect($validator->contentsIndicateIntegration('@source "resources/css/stencil.css";'))->toBeTrue();
});

it('rejects host stylesheets without owned stencil integration', function (): void {
    $validator = new TailwindIntegrationValidator;

    expect($validator->contentsIndicateIntegration('@import "tailwindcss";'))->toBeFalse();
});
