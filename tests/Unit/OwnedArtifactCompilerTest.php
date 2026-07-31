<?php

declare(strict_types=1);

use Ivanfuhr\Stencil\Registry\OwnedArtifactCompiler;

it('compiles owned blade artifacts', function (): void {
    $compiler = new OwnedArtifactCompiler;

    $source = <<<'BLADE'
@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
@endphp
<x-stencil::input />
BLADE;

    $compiled = $compiler->compileBlade($source);

    expect($compiled)->toContain('App\\Support\\Stencil\\Form\\FormControlClassMap');
    expect($compiled)->toContain('<x-ui::input />');
    expect($compiled)->not->toContain('x-stencil::');
});

it('inlines the internal loading icon partial when compiling owned button artifacts', function (): void {
    $compiler = new OwnedArtifactCompiler;

    $source = "@include('stencil::internals.loading-icon')";

    $compiled = $compiler->compileBlade($source);

    expect($compiled)->toContain('data-button-loading-icon');
    expect($compiled)->toContain('App\\Support\\Stencil\\Icon\\IconVariant::normalize');
    expect($compiled)->not->toContain('x-ui::icon.loading');
    expect($compiled)->not->toContain("@include('stencil::internals.loading-icon')");
});

it('inlines the internal loading icon partial when the include passes view data', function (): void {
    $compiler = new OwnedArtifactCompiler;

    $source = "@include('stencil::internals.loading-icon', [
    'variant' => \$variant,
    'class' => \$attributes->get('class'),
])";

    $compiled = $compiler->compileBlade($source);

    expect($compiled)->toContain('data-button-loading-icon');
    expect($compiled)->toContain('App\\Support\\Stencil\\Icon\\IconVariant::normalize');
    expect($compiled)->not->toContain('stencil::internals.loading-icon');
});

it('rewrites package translation namespaces in owned blade artifacts', function (): void {
    $compiler = new OwnedArtifactCompiler;

    $source = "{{ __('stencil::messages.date_picker_cancel') }}";

    $compiled = $compiler->compileBlade($source);

    expect($compiled)->toContain("__('stencil-ui::messages.date_picker_cancel')");
    expect($compiled)->not->toContain('stencil::messages');
});

it('rewrites package translation namespaces in owned php support artifacts', function (): void {
    $compiler = new OwnedArtifactCompiler;

    $source = "return __('stencil::messages.preset_today');";

    $compiled = $compiler->compilePhpSupport($source);

    expect($compiled)->toContain("__('stencil-ui::messages.preset_today')");
    expect($compiled)->not->toContain('stencil::messages');
});
