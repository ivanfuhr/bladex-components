<?php

declare(strict_types=1);

use Ivanfuhr\BladexComponents\Support\Tailwind\TailwindIntegrationValidator;

it('detects owned bladex tailwind markers in app stylesheets', function (): void {
    $validator = new TailwindIntegrationValidator;

    $css = '@import "tailwindcss"; /* bladex-components-start */ @import "./bladex.css"; /* bladex-components-end */';

    expect($validator->contentsIndicateIntegration($css))->toBeTrue();
});

it('detects resources/css/bladex.css marker text', function (): void {
    $validator = new TailwindIntegrationValidator;

    expect($validator->contentsIndicateIntegration('@source "resources/css/bladex.css";'))->toBeTrue();
});

it('rejects host stylesheets without owned bladex integration', function (): void {
    $validator = new TailwindIntegrationValidator;

    expect($validator->contentsIndicateIntegration('@import "tailwindcss";'))->toBeFalse();
});
