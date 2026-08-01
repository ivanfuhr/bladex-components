@aware([
    'size' => null,
    'invalid' => false,
    'fieldInvalid' => false,
    'disabled' => false,
    'currentValue' => '#000000',
    'popoverId' => null,
    'placeholderText' => '#000000',
])

@props([
    'currentValue' => '#000000',
    'popoverId' => null,
    'placeholderText' => '#000000',
    'invalid' => false,
    'disabled' => false,
    'size' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;
    use Ivanfuhr\Stencil\Support\Typography\TypographyClassMap;

    $formControl = app(FormControlClassMap::class);
    $interactionState = app(InteractionStateAttributes::class);
    $typography = app(TypographyClassMap::class);

    $isInvalid = $invalid || $fieldInvalid;
    $isSmall = $size === 'sm';

    $hexClasses = collect([
        'color-picker__hex',
        'min-w-0 flex-1 border-0 bg-transparent shadow-none',
        $typography->inputControlClasses($size),
        'font-mono uppercase tracking-wide text-zinc-950 placeholder:text-zinc-500',
        'focus-visible:outline-none focus-visible:ring-0',
        'dark:text-zinc-50 dark:placeholder:text-zinc-400',
        $isSmall ? 'px-2.5' : 'px-3',
        $isInvalid ? 'text-red-950 dark:text-red-50' : null,
    ])->filter()->implode(' ');

    $hexAttributes = $interactionState->apply(
        $attributes
            ->class($hexClasses)
            ->merge([
                'type' => 'text',
                'data-color-picker-hex' => true,
                'value' => strtoupper($currentValue),
                'placeholder' => $placeholderText,
                'spellcheck' => 'false',
                'inputmode' => 'text',
                'autocomplete' => 'off',
                'aria-label' => __('stencil::messages.color_picker_hex'),
                'aria-expanded' => 'false',
            ]),
        ['nativeDisabled' => true],
    );

    if (filled($popoverId)) {
        $hexAttributes = $hexAttributes->merge([
            'aria-controls' => $popoverId,
        ]);
    }

    if ($disabled) {
        $hexAttributes = $hexAttributes->merge(['disabled' => true]);
    }

    if ($isInvalid) {
        $hexAttributes = $hexAttributes->merge(['aria-invalid' => 'true']);
    }
@endphp

<input {{ $hexAttributes }} />
