<?php

declare(strict_types=1);

use Ivanfuhr\BladexComponents\Support\Tailwind\TailwindIntegrationValidator;

it('detects the v4 bladex tailwind import', function (): void {
    $validator = new TailwindIntegrationValidator;

    $css = '@import "tailwindcss"; @import "../../vendor/ivanfuhr/bladex-components/resources/tailwind/bladex.css";';

    expect($validator->contentsIndicateIntegration($css))->toBeTrue();
});

it('detects v3 content paths that scan package support php', function (): void {
    $validator = new TailwindIntegrationValidator;

    $config = "content: ['./vendor/ivanfuhr/bladex-components/src/Support/**/*.php']";

    expect($validator->contentsIndicateIntegration($config))->toBeTrue();
});

it('detects monorepo workbench imports of package tailwind sources', function (): void {
    $validator = new TailwindIntegrationValidator;

    $css = '@import "tailwindcss"; @import "../../../resources/tailwind/bladex.css";';

    expect($validator->contentsIndicateIntegration($css))->toBeTrue();
});

it('rejects host stylesheets without bladex tailwind sources', function (): void {
    $validator = new TailwindIntegrationValidator;

    expect($validator->contentsIndicateIntegration('@import "tailwindcss";'))->toBeFalse();
});
