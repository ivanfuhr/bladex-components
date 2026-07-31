<?php

declare(strict_types=1);

use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;

it('keeps shared choice control classes free of checked fills', function (): void {
    $classes = app(FormControlClassMap::class)->choiceControlClasses('radio');

    expect($classes)
        ->toContain('choice-control')
        ->toContain('rounded-full')
        ->not->toContain('checked:bg-zinc-900')
        ->not->toContain('checked:bg-white')
        ->not->toContain('checked:text-white');
});

it('still sizes checkbox and radio shells', function (): void {
    $map = app(FormControlClassMap::class);

    expect($map->choiceControlClasses('checkbox', 'sm'))->toContain('size-3.5')
        ->and($map->choiceControlClasses('checkbox'))->toContain('rounded-[4px]')
        ->and($map->choiceControlClasses('radio'))->toContain('size-4');
});
