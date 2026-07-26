<?php

declare(strict_types=1);

use Ivanfuhr\BladexComponents\Registry\OwnedArtifactCompiler;

it('compiles owned blade artifacts', function (): void {
    $compiler = new OwnedArtifactCompiler;

    $source = <<<'BLADE'
@php
    use Ivanfuhr\BladexComponents\Support\Form\FormControlClassMap;
@endphp
<x-bladex-components::input />
BLADE;

    $compiled = $compiler->compileBlade($source);

    expect($compiled)->toContain('App\\Support\\Bladex\\Form\\FormControlClassMap');
    expect($compiled)->toContain('<x-ui::input />');
    expect($compiled)->not->toContain('x-bladex-components::');
});
