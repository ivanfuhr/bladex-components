@props([
    'name' => null,
    'value' => '1',
    'checked' => false,
    'invalid' => false,
    'size' => null,
])

@aware([
    'controlId' => null,
    'fieldInvalid' => false,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;

    $isInvalid = $invalid || $fieldInvalid;

    $formControl = app(FormControlClassMap::class);
    $interactionState = app(InteractionStateAttributes::class);

    $controlId = $attributes->get('id')
        ?? $controlId
        ?? (filled($name) ? $name : 'switch-'.str_replace('.', '', uniqid('', true)));

    $rootClasses = $formControl->switchRootClasses($size);
    $trackClasses = $formControl->switchTrackClasses($size);
    $thumbClasses = $formControl->switchThumbClasses($size);

    $wrapperClass = $attributes->get('class');

    $controlAttributes = $interactionState->apply(
        $attributes
            ->except(['id', 'class'])
            ->class([
                'switch__input',
                'sr-only',
            ])
            ->merge([
                'type' => 'checkbox',
                'role' => 'switch',
                'id' => $controlId,
                'data-switch-control' => true,
            ]),
        ['nativeDisabled' => true],
    );

    if (filled($name)) {
        $controlAttributes = $controlAttributes->merge(['name' => $name]);
    }

    if (filled($value)) {
        $controlAttributes = $controlAttributes->merge(['value' => $value]);
    }

    if ($checked) {
        $controlAttributes = $controlAttributes->merge(['checked' => true]);
    }

    if ($isInvalid) {
        $controlAttributes = $controlAttributes->merge(['aria-invalid' => 'true']);
    }
@endphp

<div
    @class([
        'switch',
        $rootClasses,
        $size === 'sm' ? 'switch--sm' : null,
        $wrapperClass,
    ])
    data-switch
>
    <label class="inline-flex cursor-pointer items-center justify-center">
        <input {{ $controlAttributes }} />
        <span class="{{ $trackClasses }}" aria-hidden="true" data-switch-track>
            <span class="{{ $thumbClasses }}" data-switch-thumb></span>
        </span>
    </label>
</div>
