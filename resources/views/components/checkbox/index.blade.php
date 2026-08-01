@props([
    'name' => null,
    'value' => '1',
    'checked' => false,
    'invalid' => false,
    'size' => null,
])

@aware([
    'fieldInvalid' => false,
    'controlId' => null,
])

@php
    use Ivanfuhr\Stencil\Support\Form\FormControlClassMap;
    use Ivanfuhr\Stencil\Support\Interaction\InteractionStateAttributes;

    $isInvalid = $invalid || $fieldInvalid;

    $formControl = app(FormControlClassMap::class);
    $interactionState = app(InteractionStateAttributes::class);

    $resolvedControlId = $attributes->get('id')
        ?? $controlId
        ?? (filled($name) ? $name : null);

    // Checkmark SVG is applied in stencil.css — Tailwind does not emit
    // checked:bg-[url(data:...)] when the class lives only inside a PHP string.
    $controlClasses = collect([
        $formControl->choiceControlClasses('checkbox', $size),
        'appearance-none',
        'checked:border-zinc-900 checked:bg-zinc-900',
        'dark:checked:border-zinc-50 dark:checked:bg-zinc-50',
    ])->implode(' ');

    $controlAttributes = $interactionState->apply(
        $attributes
            ->except(['id'])
            ->class($controlClasses)
            ->merge([
                'type' => 'checkbox',
                'data-checkbox-control' => true,
            ]),
        ['nativeDisabled' => true],
    );

    if (filled($resolvedControlId)) {
        $controlAttributes = $controlAttributes->merge(['id' => $resolvedControlId]);
    }

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

<div class="checkbox inline-flex items-center" data-checkbox>
    <input {{ $controlAttributes }} />
</div>
