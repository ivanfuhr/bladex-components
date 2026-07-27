<?php

declare(strict_types=1);

it('ships class-based dark mode in the stencil.css init stub', function (): void {
    $stub = file_get_contents(dirname(__DIR__, 2).'/stubs/resources/css/stencil.css');

    expect($stub)->toBeString()
        ->toContain('@custom-variant dark')
        ->toContain('.dark');
});
