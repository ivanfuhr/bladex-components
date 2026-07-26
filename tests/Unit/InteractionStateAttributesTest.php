<?php

declare(strict_types=1);

use Illuminate\View\ComponentAttributeBag;
use Ivanfuhr\BladexComponents\Support\Interaction\InteractionStateAttributes;

it('treats data-loading and aria-busy as loading states', function (): void {
    $state = app(InteractionStateAttributes::class);

    expect($state->isLoading(new ComponentAttributeBag(['data-loading' => true])))->toBeTrue()
        ->and($state->isLoading(new ComponentAttributeBag(['data-loading' => ''])))->toBeTrue()
        ->and($state->isLoading(new ComponentAttributeBag(['aria-busy' => 'true'])))->toBeTrue()
        ->and($state->isLoading(new ComponentAttributeBag(['data-loading' => false])))->toBeFalse();
});

it('adds aria-busy when loading is active', function (): void {
    $state = app(InteractionStateAttributes::class);

    $applied = $state->apply(new ComponentAttributeBag(['data-loading' => true]));

    expect($applied->get('aria-busy'))->toBe('true');
});

it('maps disabled to aria-disabled for non-native controls', function (): void {
    $state = app(InteractionStateAttributes::class);

    $applied = $state->apply(
        new ComponentAttributeBag(['disabled' => true]),
        ['nativeDisabled' => false],
    );

    expect($applied->has('disabled'))->toBeFalse()
        ->and($applied->get('aria-disabled'))->toBe('true')
        ->and($applied->get('tabindex'))->toBe('-1');
});

it('merges data-loading when loading option is true', function (): void {
    $state = app(InteractionStateAttributes::class);

    $applied = $state->apply(new ComponentAttributeBag, ['loading' => true]);

    expect($applied->get('data-loading'))->toBeTrue()
        ->and($applied->get('aria-busy'))->toBe('true');
});
