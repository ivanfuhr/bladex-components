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
